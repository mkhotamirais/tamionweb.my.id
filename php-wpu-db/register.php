<?php

require 'functions.php';

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "
        <script>
            alert('user baru berhasil ditambahkan');
            document.location.href = 'index2.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
        echo "
        <script>
            alert('user baru gagal ditambahkan');
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
</head>

<body>
    <h1>register</h1>
    <form action="" method="post">
        <input type="text" name="username" placeholder="username" />
        <input type="password" name="password" placeholder="password" />
        <input type="password" name="password2" placeholder="konfirmasi password" />
        <button type="submit" name="register">register</button>
    </form>
</body>

</html>