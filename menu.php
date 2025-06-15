<?php
session_start();
require_once('./classes/database_customers.php');

if (!isset($_SESSION['customer_ID'])) {
    header('Location: login.php');
    exit();
}

$db = new database_customers();
$con = $db->getConnection(); //

$customerId = $_SESSION['customer_ID'];
$orderType = $_SESSION['order_type'] ?? 'dinein';
// Check if an order already exists for this session
$orderId = $_SESSION['order_id'] ?? null;

if (!$orderId) {
    // Check if there's an existing pending order in the DB
    $stmt = $con->prepare("SELECT order_id FROM orders WHERE customer_ID = ? AND status = 'pending' ORDER BY created_at DESC LIMIT 1");
    $stmt->execute([$customerId]);
    $existingOrder = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingOrder) {
        $orderId = $existingOrder['order_id'];
    } else {
        // Create new order
        $stmt = $con->prepare("INSERT INTO orders (customer_ID, order_type, status, created_at) VALUES (?, ?, 'pending', NOW())");
        $stmt->execute([$customerId, $orderType]);
        $orderId = $con->lastInsertId();
    }

    $_SESSION['order_id'] = $orderId;
}


$actionResult = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_item_id'])) {
        $stmt = $con->prepare("DELETE FROM order_items WHERE order_id = ? AND item_id = ?");
        $stmt->execute([$orderId, $_POST['remove_item_id']]);
        $actionResult = "removed";
    } elseif (isset($_POST['action'], $_POST['item_id'], $_POST['quantity'])) {
        $itemId = $_POST['item_id'];
        $quantity = max(1, (int)$_POST['quantity']);
        $actionType = $_POST['action'];
        // Remove old if replace
        if ($actionType === 'replace' && $itemId) {
            $stmt = $con->prepare("DELETE FROM order_items WHERE order_id = ? AND item_id = ?");
            $stmt->execute([$orderId, $_POST['replace_item_id']]);
        }
        // Insert new or add
        $stmt = $con->prepare(
            "INSERT INTO order_items (order_id, item_id, quantity)
             VALUES (?, ?, ?)
             ON DUPLICATE KEY UPDATE quantity = VALUES(quantity)"
        );
        $stmt->execute([$orderId, $itemId, $quantity]);
        $actionResult = $actionType === 'replace' ? "replaced" : "added";
    }
}

// categories and menu
$selectedCategory = $_GET['category'] ?? '';
$query = "SELECT * FROM menu_items" . ($selectedCategory ? " WHERE category = ?" : "");
$stmt = $con->prepare($query);
$stmt->execute($selectedCategory ? [$selectedCategory] : []);
$menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// grouped
$menuByCat = [];
foreach ($menuItems as $it) {
    $menuByCat[$it['category']][] = $it;
}

// current cart
$stmt = $con->prepare(
    "SELECT oi.item_id, mi.item_name, mi.price, mi.item_image, oi.quantity
     FROM order_items oi JOIN menu_items mi USING(item_id)
     WHERE oi.order_id = ?"
);
$stmt->execute([$orderId]);
$orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalAmount = array_reduce($orderItems, fn($sum, $i) => $sum + $i['price'] * $i['quantity'], 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Brew Bliss Menu</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {background:#f8f4f0;font-family:'Segoe UI',sans-serif;}
    .menu-card{background:#fff;border:1px solid #e0cfc1;border-radius:12px;padding:15px;box-shadow:0 4px 8px rgba(0,0,0,0.05);transition:transform .2s;}
    .menu-card:hover{transform:translateY(-5px);}
    .modal-body {
  max-height: 70vh;
  overflow-y: auto;
}
.modal-body {
  max-height: 70vh;
  overflow-y: auto;
  padding: 1rem;
}

.modal-body .card {
  border: 1px solid #e0cfc1;
  border-radius: 12px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  transition: transform 0.2s;
}

.modal-body .card:hover {
  transform: translateY(-4px);
}



.modal-body .card-body {
  padding: 0.75rem;
  text-align: center;
}

    .menu-card img{height:160px;object-fit:cover;width:100%;border-radius:10px;margin-bottom:10px;}
    .menu-title{font-weight:bold;color:#4e342e;display:flex;justify-content:space-between;align-items:center;}
    .price{color:#6d4c41;font-weight:600;}
    .quantity-input{width:60px;border-radius:8px;}
    .category-header{margin-top:30px;color:#5d4037;border-bottom:2px solid #d7ccc8;padding-bottom:4px;}
    .best-seller{background:#ff7043;color:#fff;font-size:.75rem;font-weight:bold;padding:2px 8px;border-radius:12px;}
    .sticky-footer{position:sticky;bottom:0;background:#fff3e0;padding:12px 20px;box-shadow:0 -2px 8px rgba(0,0,0,0.1);}
    .btn-add{background:#6d4c41;color:#fff;}
    .btn-add:hover{background:#5d4037;}
    .btn-replace{background:#ffb74d;color:#fff;}
    .btn-replace:hover{background:#ffa726;}
    header{padding:30px 0 10px;text-align:center;}
    .logo{font-size:2.4rem;font-weight:bold;color:#5d4037;}
    .tagline{color:#8d6e63;}
  </style>
</head>
<body class="container py-4">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm rounded mb-4">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold text-brown" href="#"><i class="fas fa-mug-hot"></i> IZANA</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUserMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarUserMenu">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navAccount" role="button" data-bs-toggle="dropdown">
              <i class="fas fa-user-circle"></i> My Account
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="change_password.php"><i class="fas fa-key"></i> Change Password</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <header>
    <div class="logo">☕ Brew Bliss Coffee</div>
    <div class="tagline">Savor the Moment with Every Sip</div>
  </header>

  <!-- Category Filter -->
  <div class="text-center mb-3">
    <form method="get">
      <select name="category" onchange="this.form.submit()" class="form-select d-inline-block w-auto">
        <option value="">All Categories</option>
        <?php foreach ($con->query("SELECT DISTINCT category FROM menu_items")->fetchAll(PDO::FETCH_COLUMN) as $cat): ?>
          <option <?= $cat === $selectedCategory ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
        <?php endforeach;?>
      </select>
    </form>
  </div>

  <!-- Menu Items -->
  <?php foreach ($menuByCat as $cat => $items): ?>
    <h4 class="category-header"><?= htmlspecialchars($cat) ?></h4>
    <div class="row g-4 mb-3">
      <?php foreach ($items as $item):
        $name = strtolower($item['item_name']);
       $isBest = str_contains($name, 'spanish latte') || 
         (str_contains($item['category'], 'Mango Supreme') &&
          (str_contains($name, 'caramel large') || str_contains($name, 'cream cheese large')));

      ?>
      <div class="col-md-4 col-lg-3">
        <div class="menu-card h-100">
          <?php if ($item['item_image']): ?>
            <img src="<?= htmlspecialchars($item['item_image']) ?>" alt="">
          <?php endif; ?>
          <div class="menu-title">
            <?= htmlspecialchars($item['item_name']) ?>
            <?php if ($isBest): ?><span class="best-seller">Best Seller</span><?php endif; ?>
          </div>
          <div class="price">₱<?= number_format($item['price'],2) ?></div>
          <form method="post" class="mt-2">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
            <div class="input-group mb-2">
              <input type="number" name="quantity" value="1" min="1" class="form-control quantity-input">
            </div>
            <button type="submit" class="btn btn-add btn-sm w-100"><i class="fa fa-plus"></i> Add</button>
          </form>
        </div>
      </div>
      <?php endforeach;?>
    </div>
  <?php endforeach;?>

  <!-- Cart -->
  <h3 class="text-center mb-3">🛒 Your Cart</h3>
  <div class="table-responsive mb-5">
    <table class="table table-bordered table-striped">
      <thead class="table-dark"><tr><th>Item</th><th>Price</th><th>Qty</th><th>Subtotal</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($orderItems as $it): ?>
        <tr>
          <td><?= htmlspecialchars($it['item_name']) ?></td>
          <td>₱<?= number_format($it['price'],2) ?></td>
          <td><?= $it['quantity'] ?></td>
          <td>₱<?= number_format($it['price'] * $it['quantity'],2) ?></td>
          <td>
            <form method="post" style="display:inline">
              <input type="hidden" name="remove_item_id" value="<?= $it['item_id'] ?>">
              <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
            </form>
            <button class="btn btn-warning btn-sm mt-1" onclick="showReplaceModal(<?= $it['item_id'] ?>, <?= $it['quantity'] ?>)">
              <i class="fa fa-sync-alt"></i> Replace
            </button>
          </td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>

  <!-- Action Buttons -->
  <div class="sticky-footer d-flex justify-content-between">
    <h4>Total: ₱<?= number_format($totalAmount,2) ?></h4>
    <div>
      <button class="btn btn-outline-danger me-2" onclick="handleClear()">🗑 Clear Cart</button>
      <button class="btn btn-success" onclick="handleCheckout()">✅ Checkout</button>
    </div>
  </div>

  <footer><small>© <?= date('Y') ?> Brew Bliss Coffee</small></footer>

  <!-- Replace Modal -->
  <div class="modal fade" id="replaceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <form method="post">
          <div class="modal-header">
            <h5 class="modal-title">Replace Item</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="action" value="replace">
            <input type="hidden" name="replace_item_id" id="replace_item_id">
            <label>Quantity:</label>
            <input type="number" name="quantity" id="replace_qty" class="form-control mb-3" min="1">
            <div class="row">
            <?php foreach ($menuItems as $mi): 
  $mi_name = strtolower($mi['item_name']);
  $isBest = str_contains($mi_name, 'spanish latte') || 
            (str_contains($mi['category'], 'Mango Supreme') &&
             (str_contains($mi_name, 'caramel large') || str_contains($mi_name, 'cream cheese large')));
?>

              <div class="col-md-4 mb-3">
                <div class="card h-100">
                  <img src="<?= htmlspecialchars($mi['item_image']) ?>" class="card-img-top">
                  <div class="card-body">
                   <h5>
  <?= htmlspecialchars($mi['item_name']) ?>
  <?php if ($isBest): ?><span class="badge bg-warning text-dark ms-1">Best Seller</span><?php endif; ?>
</h5>

                    <p>₱<?= number_format($mi['price'],2) ?></p>
                    <button type="submit" name="item_id" value="<?= $mi['item_id'] ?>" class="btn btn-outline-primary w-100">Select</button>
                  </div>
                </div>
              </div>
              <?php endforeach;?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    <?php if ($actionResult): ?>
      Swal.fire({
        icon: '<?= $actionResult === "added" ? "success" : ($actionResult === "removed" ? "warning" : "info") ?>',
        title: '<?= ucfirst($actionResult) ?>',
        timer: 1000,
        showConfirmButton: false
      });
    <?php endif;?>

    const cartCount = <?= count($orderItems) ?>;
    function handleClear() {
      if (cartCount === 0) return Swal.fire({icon:'info',title:'Cart is empty'});
      window.location.href = 'clear_cart.php';
    }
    function handleCheckout() {
      if (cartCount === 0) return Swal.fire({icon:'warning',title:'Add items first'});
      window.location.href = 'checkout.php';
    }

    function showReplaceModal(id, qty) {
      document.getElementById('replace_item_id').value = id;
      document.getElementById('replace_qty').value = qty;
      new bootstrap.Modal(document.getElementById('replaceModal')).show();
    }ss
  </script>
</body>
</html>