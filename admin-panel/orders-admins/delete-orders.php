<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php" ?>

<?php

if (!isset($_SERVER['HTTP_REFERER'])) {
    // redirect them to your desired location
    header('location: http://localhost/coffee-blend');
    exit;
}

if (!isset($_SESSION['admin_name'])) {
    header("location: " . ADMINURL . "/admins/login-admins.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = $conn->prepare("DELETE FROM orders WHERE id ='$id'");
    $delete->execute();

    header("Location: show-orders.php");
}