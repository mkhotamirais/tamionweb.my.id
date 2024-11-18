<?php
session_start();
require 'functions.php';

// if (!isset($_SESSION["login"])) {
//     header("Location: login.php");
//     exit;
// }

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}


$keyword = $_POST['keyword'] ?? "";

$dataPerPage = 2;
$totalData = count(query("SELECT * FROM mahasiswa"));
$totalPage = ceil($totalData / $dataPerPage);
if ($_GET['page'] < 1) {
    $_GET['page'] = 1;
} else if ($_GET['page'] > $totalPage) {
    $_GET['page'] = $totalPage;
}
$activePage = $_GET['page'] ?? 1;

$firstData = $dataPerPage * $activePage - $dataPerPage;

$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $firstData, $dataPerPage");

if (isset($_POST['cari']) && isset($keyword)) {
    $mahasiswa = query("SELECT * FROM mahasiswa WHERE nama LIKE '%$keyword%' or nrp LIKE '%$keyword%' or email LIKE '%$keyword%' or jurusan LIKE '%$keyword%'");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wpu php dasar refactoring</title>
</head>

<body>
    <h1>wpu php dasar refactoring</h1>
    <h3>daftar mahasiswa</h3>
    <div>
        <a href="register.php">register</a>
        <br>
        <a href="login.php">login</a>
        <br>
        <a href="logout.php">logout</a>
        <br>
    </div>
    <br>
    <div>
        <a href="tambah.php">tambah data</a>
    </div>
    <br>
    <form action="" method="post">
        <input type="text" name="keyword" size="40" autofocus placeholder="masukan keyword pencarian.." autocomplete="off">
        <button type="submit" name="cari">cari</button>
    </form>
    <input type="text" name="keylive" id="keylive" placeholder="live search.." autocomplete="off" />
    <div>
        <!-- prev -->
        <?php if ($activePage > 1) : ?>
            <a href="?page=<?= $activePage - 1; ?>">prev</a>
        <?php endif; ?>
        <!-- page numbers -->
        <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
            <a href="?page=<?= $i; ?>" style="text-decoration: none; <?= $activePage == $i ? 'font-weight: bold; border: 1px solid' : ''; ?>"><?= $i; ?></a>
        <?php endfor; ?>
        <!-- next -->
        <?php if ($activePage < $totalPage) : ?>
            <a href="?page=<?= $activePage + 1; ?>">next</a>
        <?php endif; ?>
    </div>

    <div id="container">
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Gambar</th>
                    <th>NRP</th>
                    <th>Email</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 1; ?>
                <?php foreach ($mahasiswa as $mhs) : ?>
                    <tr>
                        <td><?= $id++ ?></td>
                        <td><?= $mhs["nama"]; ?></td>
                        <td><img src="<?= "img/" . $mhs["gambar"]; ?>" width="50"></td>
                        <td><?= $mhs["nrp"]; ?></td>
                        <td><?= $mhs["email"]; ?></td>
                        <td><?= $mhs["jurusan"]; ?></td>
                        <td>
                            <a href="ubah.php?id=<?= $mhs["id"]; ?>">ubah</a> |
                            <a href="hapus.php?id=<?= $mhs["id"]; ?>" onclick="return confirm('yakin?')">hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <!-- script -->
    <script src="script.js"></script>
</body>

</html>