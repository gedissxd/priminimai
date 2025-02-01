<?php
session_start();

require_once "database/db.php";
require_once "database/data.php";
require_once "functions.php";


$error = '';
$username = '';

if (isset($_POST['submit'])) {
    $username = test_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = '<div class="text-red-500 text-center font-bold">Please fill in all fields</div>';
    } else {

        $hashedPassword = sha1($password . $salt);


        $stmt = mysqli_prepare($conn, "SELECT personID FROM `person` WHERE `personName` = ? AND `personPassword` = ?");
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPassword);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {

            mysqli_stmt_bind_result($stmt, $personId);
            mysqli_stmt_fetch($stmt);


            $_SESSION['logged'] = true;
            $_SESSION['user_id'] = $personId;

            header("Location: index.php");
            exit();
        } else {
            $error = '<div class="text-red-500 text-center font-bold">Wrong username or password</div>';
        }

        mysqli_stmt_close($stmt);

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Forum - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#4C4E4F]">
    <div class="flex justify-center items-center h-screen">
        <form method="post" class="bg-[#89985B] border-2 border-solid rounded-2xl p-5 flex flex-col gap-2 text-white">
            <h1 class="text-2xl text-center font-bold text-white">Login Panel</h1>

            <input class="p-2 rounded-md bg-gray-200 text-black" type="text" name="username" placeholder="Username"
                value="<?= $username; ?>" required>

            <input class="p-2 rounded-md bg-gray-200 text-black" type="password" name="password" placeholder="Password"
                required>

            <input class="p-2 rounded-md bg-gray-200 hover:bg-gray-300 text-black cursor-pointer" type="submit"
                name="submit" value="Enter">

            <?php if ($error): ?>
            <?= $error; ?>
            <?php endif; ?>
            <a href="create.php" class="block">
                <input type="button" value="Create account"
                    class="w-full p-2 rounded-md bg-gray-200 hover:bg-gray-300 text-black cursor-pointer">
            </a>
        </form>


    </div>
</body>

</html>