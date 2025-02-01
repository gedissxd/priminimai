<?php
session_start();



require_once 'database/db.php';
require_once 'database/data.php';
require_once 'functions.php';



$formErrors = [];
$formSubmitted = isset($_POST['submit']);
$name = "";
$password = "";

if ($formSubmitted) {

    $name = verify('name', $formErrors);

    if (isset($_POST['password']) && trim($_POST['password']) !== '') {
        $password = sha1(test_input($_POST['password']) . $salt);
    } else {
        $formErrors['password'] = 'Password cannot be empty.';
    }

    if (empty($formErrors)) {
        $stmt = $conn->prepare("INSERT INTO person (personName, personPassword) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $password);

        if ($stmt->execute()) {
            $newPersonId = $stmt->insert_id;
            
            $stmt->close();
            mysqli_close($conn);
            
            $_SESSION['personID'] = $newPersonId;
            
            header('Location: login.php');
            exit();
        } else {
            $formErrors['database'] = "Error: " . $stmt->error;
        }

    }
}

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
            <input class="block w-full rounded-lg text-black bg-gray-200 p-2" type="text" name="name"
                placeholder="Enter name" maxlength="100" value="<?= $name; ?>">
            <?php if (isset($formErrors['name'])): ?>
            <span class="text-red-600 text-sm mt-1 font-semibold"><?= $formErrors['name'] ?></span>
            <?php endif; ?>
        </div>

        <div>
            <input class="block w-full rounded-lg text-black bg-gray-200 p-2" type="password" name="password"
                placeholder="Enter password">
            <?php if (isset($formErrors['password'])): ?>
            <span class="text-red-600 text-sm mt-1 font-semibold"><?= $formErrors['password']; ?></span>
            <?php endif; ?>
        </div>

        <input type="submit" name="submit" value="Submit"
            class="block w-full rounded-lg bg-gray-200 hover:bg-gray-300 text-black p-2 cursor-pointer">

        <a href="login.php" class="block">
            <input type="button" value="Go back"
                class="w-full p-2 rounded-md bg-gray-200 hover:bg-gray-300 text-black cursor-pointer">
        </a>
    </form>

    <?php endif; ?>
</body>

</html>