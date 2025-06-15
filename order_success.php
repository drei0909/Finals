<?php
session_start();
if (!isset($_GET['order_id'])) {
    header("Location: menu.php");
    exit();
}

$orderId = $_GET['order_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Success - Brew Bliss</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta http-equiv="refresh" content="5;url=menu.php"> <!-- Optional: redirect after 5 seconds -->
  <style>
    body {
      background-color: #fff8f0;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
  </style>
</head>
<body>

<script>
  Swal.fire({
    icon: 'success',
    title: 'Order Confirmed!',
    html: 'Your order <strong>#<?= htmlspecialchars($orderId) ?></strong> has been successfully placed.<br><br>You will be redirected to the menu in a few seconds.',
    confirmButtonText: 'Go Now',
    timer: 5000,
    timerProgressBar: true
  }).then((result) => {
    window.location.href = 'menu.php';
  });
</script>

</body>
</html>
