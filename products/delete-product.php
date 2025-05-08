<?php require "../includes/header.php"; ?>
<?php require "../config/config.php" ?>

<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: " . APPURL . " ");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = $conn->prepare("DELETE FROM cart WHERE id ='$id'");
    $delete->execute();

    header("Location: cart.php");
}