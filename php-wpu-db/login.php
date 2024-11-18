<?php
session_start();
require 'functions.php';

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_COOKIE['login'])) {
    if ($_COOKIE['login'] === 'true') {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: index2.php");
    exit;
}


if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            header("Location: index2.php");
            // set session
            $_SESSION["login"] = true;
            // cek remember me
            if (isset($_POST['remember'])) {
                // buat cookie
                setcookie("id", $row['id'], time() + 60 * 2);
                setcookie("key", hash('sha256', $row['username']), time() + 60 * 2);

                // setcookie("login", 'true', time() + 60 * 2);
            }
            exit;
        }
    }

    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>

<body>
    <h1>login</h1>
    <?php if (isset($error)) : ?><p style="color: red">username atau password salah</p><?php endif; ?>
    <form action="" method="post">
        <input type="text" name="username" placeholder="username" />
        <input type="password" name="password" placeholder="******" />
        <input type="checkbox" name="remember" id="remember" /> Remember me
        <button type="submit" name="login">login</button>
    </form>
</body>

</html>