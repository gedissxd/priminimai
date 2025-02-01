<?php
session_start();

if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    header('Location: login.php');
    exit();
}

require_once 'database/db.php';
require_once 'database/data.php';
require_once 'functions.php';

$formErrors = [];
$formSubmitted = isset($_POST['submit']);
$message = "";
$date = "";
$userId = $_SESSION['user_id']; 
if ($formSubmitted) {
    if (isset($_POST['message']) && trim($_POST['message']) !== '') {
        $message = $_POST['message'];
    } else {
        $formErrors['message'] = 'message cannot be empty.';
    }
    if (isset($_POST['date']) && $_POST['date'] !== '') {
        $date = $_POST['date'];
    } else {
        $formErrors['date'] = 'Date cannot be empty.';
    }

    if (empty($formErrors)) {
        $stmt = $conn->prepare("INSERT INTO personreminder (personReminder, personID, personDate) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $message, $userId, $date);
        $stmt->execute();
        $stmt->close();
        mysqli_close($conn);
        header('Location: reminder.php');
        exit();
    }
}

require_once "navbar.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#4C4E4F] flex justify-center items-center h-screen pt-16">
    <?php if (!$formSubmitted || !empty($formErrors)): ?>
        <form class="bg-[#89985B] border-2 text-white rounded-2xl p-4 flex flex-col gap-4 w-[400px]" method="post">
            <h1 class="text-3xl font-bold">Create account</h1>
            <div>
                <textarea class="block w-full rounded-lg text-black bg-gray-200 p-2 resize-none" name="message"
                    placeholder="Reminder"><?= $message; ?></textarea>
                <?php if (isset($formErrors['message'])): ?>
                    <span class="text-red-600 text-sm mt-1 font-semibold"><?= $formErrors['message']; ?></span>
                <?php endif; ?>
            </div>

            <div>
                <input class="block w-full rounded-lg text-black bg-gray-200 p-2" type="date" name="date" min="<?= date('Y-m-d')?>"
                    value="<?= $date; ?>" />
                <?php if (isset($formErrors['date'])): ?>
                    <span class="text-red-600 text-sm mt-1 font-semibold"><?= $formErrors['date']; ?></span>
                <?php endif; ?>
            </div>

            <input type="submit" name="submit" value="Submit"
                class="block w-full rounded-lg bg-gray-200 hover:bg-gray-300 text-black p-2 cursor-pointer">
        </form>
    <?php endif; ?>
</body>

</html>