<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "wpu_php_dasar") or die("Koneksi Gagal");

// query isi tabel
$result = mysqli_query($conn, "SELECT * FROM mahasiswa");
// var_dump($result);

// fetch data (4 cara)

// cara 1 : mysqli_fetch_row()       mengembalikan numerik array
// $mhs = mysqli_fetch_row($result);
// var_dump($mhs[1]);

// cara 2 : mysqli_fetch_assoc()     mengembalikan associative array
// $mhs = mysqli_fetch_assoc($result);
// var_dump($mhs["nama"]);

// cara 3 : mysqli_fetch_array()     mengembalikan numerik sekaligus associative array
// $mhs = mysqli_fetch_array($result);
// var_dump($mhs["nama"], $mhs[1]);

// cara 4 : mysqli_fetch_object()    mengembalikan object dengan tanda panah data->arr
// $mhs = mysqli_fetch_object($result);
// var_dump($mhs->nama);

// untuk mendapat semua data
// while ($row = mysqli_fetch_array($result)) {
//     var_dump($row);
// }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wpu php dasar</title>
</head>

<body>
    <h1>wpu php dasar</h1>
    <h3>daftar mahasiswa</h3>
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
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= $id++ ?></td>
                    <td><?= $row["nama"]; ?></td>
                    <td><img src="<?= $row["gambar"]; ?>" width="50"></td>
                    <td><?= $row["nrp"]; ?></td>
                    <td><?= $row["email"]; ?></td>
                    <td><?= $row["jurusan"]; ?></td>
                    <td>
                        <a href="">ubah</a> | <a href="">hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>