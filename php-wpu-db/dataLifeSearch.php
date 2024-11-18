<?php

require "functions.php";

$keyword = $_GET["keyword"];

$query = "SELECT * FROM mahasiswa WHERE nama LIKE '%$keyword%' OR nrp LIKE '%$keyword%' OR email LIKE '%$keyword%' OR jurusan LIKE '%$keyword%'";
$mahasiswa = query($query);

?>

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