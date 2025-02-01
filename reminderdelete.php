<?php
session_start();

require_once "database/db.php";


if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $sql = "DELETE FROM personreminder WHERE personReminderID = $_GET[id]";
    $result = mysqli_query($conn, $sql);
    header('Location: reminder.php');
    exit();
} else {
    header('Location: index.php');
    exit();
}