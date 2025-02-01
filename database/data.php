<?php



$salt = "543dsf564hgf564|$54vf54dsf54!!4fdf";


if(isset($_SESSION['logged']) && isset($_SESSION['user_id'])) {
    $sql = "SELECT * FROM `personreminder` WHERE personID = " . $_SESSION['user_id'];
    $result = mysqli_query($conn, $sql);
    $reminderList = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $reminderList = array();
}


if(isset($_SESSION['logged']) && isset($_SESSION['user_id'])) {
    $sql = "SELECT * FROM `person` WHERE personID = " . $_SESSION['user_id'];
    $result = mysqli_query($conn, $sql);
    $personList = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $personList = array(); 
}