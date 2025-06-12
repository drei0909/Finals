<?php
session_start();

if (isset($_GET['item_id'])) {
    $itemId = (int)$_GET['item_id'];

    // Remove the item from session cart
    if (isset($_SESSION['cart'][$itemId])) {
        unset($_SESSION['cart'][$itemId]);
    }
}

header('Location: cart.php'); // or menu.php
exit();
