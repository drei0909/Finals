<?php
session_start();
session_unset();
session_destroy();
header("Location: admin_L.php"); // Redirect to admin login
exit();
?>
