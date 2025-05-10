<?php require "../includes/header.php"; ?>
<?php require "../config/config.php" ?>

<?php
$delete_cart = $conn->query("DELETE FROM cart WHERE user_id = '$_SESSION[user_id]'");
$delete_cart->execute();

header("location: cart.php");