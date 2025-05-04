<?php
session_start();
require "../config/config.php";

// Cek login
if (!isset($_SESSION['username'])) {
    header("location: " . APPURL . "/auth/login.php");
    exit;
}

// Jangan redirect user login ke halaman lain, karena justru kita ingin dia bisa book
// Jadi blok ini dihapus:
// if (isset($_SESSION['username'])) {
//     header("location: " . APPURL . "");
// }

if (isset($_POST['submit'])) {
    if (
        empty($_POST['first_name']) ||
        empty($_POST['last_name']) ||
        empty($_POST['date']) ||
        empty($_POST['time']) ||
        empty($_POST['phone']) ||
        empty($_POST['message'])
    ) {
        echo "<script>alert('one or more input are empty'); window.history.back();</script>";
        exit;
    }

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    // Pastikan format tanggal sesuai
    if (strtotime($date) > strtotime(date("Y-m-d"))) {
        $insert = $conn->prepare("INSERT INTO bookings (first_name, last_name, date, time, phone, message, user_id) VALUES (:first_name, :last_name, :date, :time, :phone, :message, :user_id)");

        $insert->execute([
            ":first_name" => $first_name,
            ":last_name" => $last_name,
            ":date" => $date,
            ":time" => $time,
            ":phone" => $phone,
            ":message" => $message,
            ":user_id" => $user_id,
        ]);

        echo "<script>alert('You booked this table successfully'); window.location.href = '" . APPURL . "';</script>";
        exit;
    } else {
        echo "<script>alert('Choose a valid date, you cannot choose a date in the past'); window.history.back();</script>";
        exit;
    }
}
?>