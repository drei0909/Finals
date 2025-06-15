<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu Preview | IZANA Coffee Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #fffaf5;
      font-family: 'Segoe UI', sans-serif;
    }

    .navbar {
      background-color: #6d4c41;
    }

    .navbar-brand, .nav-link {
      color: #fff !important;
      font-weight: 500;
    }

    .section-title {
      color: #6d4c41;
      font-weight: bold;
    }

    .menu-category {
      background-color: #fff3e0;
      border-radius: 12px;
      padding: 30px;
      margin-bottom: 30px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .menu-category h3 {
      color: #6d4c41;
      font-weight: 700;
    }

    .menu-item {
      display: flex;
      align-items: center;
      margin: 15px 0;
    }

    .menu-item img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
      margin-right: 15px;
    }

    .item-text {
      font-size: 16px;
    }

    .best-seller {
      color: #6d4c41;
      font-weight: bold;
      margin-left: 8px;
      font-size: 0.9rem;
      background: #fff3cd;
      padding: 2px 6px;
      border-radius: 5px;
    }

    footer {
      background-color: #6d4c41;
      color: white;
      text-align: center;
      padding: 15px;
      margin-top: 40px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" role="navigation" aria-label="Main navigation">
  <div class="container">
    <a class="navbar-brand" href="#">IZANA Coffee Shop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon text-white"><i class="fas fa-bars"></i></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="menu_preview.php">Menu Preview</a></li>

        <!-- Login Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Login
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown">
            <li><a class="dropdown-item" href="login.php">Customer Login</a></li>
            <li><a class="dropdown-item" href="admin_L.php">Admin Login</a></li>
          </ul>
        </li>

        <!-- Register Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="registerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Register
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="registerDropdown">
            <li><a class="dropdown-item" href="registration_C.php">Customer Register</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
  <h2 class="section-title text-center mb-5">IZANA Coffee + Desserts Menu</h2>

  <!-- HOT LATTE -->
  <div class="menu-category">
    <h3>HOT LATTE (12oz)</h3>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Caffe Americano – ₱70</span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Latte – ₱90</span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Cappuccino – ₱90</span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Caramel Macchiato – ₱90</span></div>
  </div>

  <!-- ICED LATTE -->
  <div class="menu-category">
    <h3>ICED LATTE (16oz)</h3>
    <div class="menu-item"><img src="assets/t.JPG" alt=""><span class="item-text">Iced Caffe Americano – ₱90</span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Iced White Chocolate Mocha – ₱100</span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Iced Spanish Latte – ₱100 <span class="best-seller">⭐ Best Seller</span></span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Iced Caffe Latte – ₱100</span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Iced Caffe Mocha – ₱100</span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Iced Caramel Macchiato – ₱100</span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Iced Strawberry Latte – ₱100</span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Iced Sea Salt Latte – ₱110</span></div>
  </div>

  <!-- FRAPPE -->
  <div class="menu-category">
    <h3>FRAPPE (16oz)</h3>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Dark Mocha – ₱120</span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Coffee Jelly – ₱120</span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Java Chip – ₱120</span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Strawberries & Cream – ₱120</span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Matcha – ₱120</span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Dark Chocolate M&M – ₱100</span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Red Velvet Oreo – ₱100</span></div>
  </div>

  <!-- MANGO SUPREME -->
  <div class="menu-category">
    <h3>MANGO SUPREME (S / L)</h3>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Caramel – ₱80 / ₱90 <span class="best-seller">⭐ Best Seller</span></span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Cream Cheese – ₱80 / ₱90</span></div>
  </div>

  <!-- MATCHA -->
  <div class="menu-category">
    <h3>MATCHA (Ceremonial Grade) (16oz)</h3>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Matcha Latte – ₱120</span></div>
    <div class="menu-item"><img src="assets/t.jpg" alt=""><span class="item-text">Matcha Strawberry Latte – ₱140</span></div>
  </div>

  <!-- ADD ONS -->
  <div class="menu-category">
    <h3>ADD ONS & EXTRAS</h3>
    <p class="menu-item">Pearl – ₱20</p>
    <p class="menu-item">Whip Cream – ₱20</p>
    <p class="menu-item">Espresso Shot – ₱30</p>
  </div>

  <div class="alert alert-warning mt-5 text-center" role="alert">
    To place an order, please <a href="registration_C.php" class="alert-link">register</a> or <a href="login.php" class="alert-link">login</a> first.
  </div>
</div>

<footer>
  &copy; <?= date('Y') ?> IZANA Coffee Shop. All Rights Reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
