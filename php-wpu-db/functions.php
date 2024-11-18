<?php
$halo = "hello world";
$conn = mysqli_connect("localhost", "root", "", "wpu_php_dasar") or die("Koneksi Gagal");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($post)
{
    global $conn;

    $nama = htmlspecialchars($post['nama']);
    $nrp = htmlspecialchars($post['nrp']);
    $email = htmlspecialchars($post['email']);
    $jurusan = htmlspecialchars($post['jurusan']);
    // $gambar = htmlspecialchars($post['gambar']);

    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO mahasiswa VALUES ('', '$nama', '$nrp', '$email', '$jurusan', '$gambar')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapus($id)
{
    global $conn;
    $query = "DELETE FROM mahasiswa WHERE id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


function ubah($post)
{
    global $conn;

    $id = htmlspecialchars($post["id"]);

    $nama = htmlspecialchars($post['nama']);
    $nrp = htmlspecialchars($post['nrp']);
    $email = htmlspecialchars($post['email']);
    $jurusan = htmlspecialchars($post['jurusan']);
    // $gambar = htmlspecialchars($post['gambar']);

    $gambar_lama = htmlspecialchars($post['gambar_lama']);

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambar_lama;
    } else {
        $gambar = upload();
        if ($gambar_lama && file_exists("img/$gambar_lama")) {
            unlink("img/$gambar_lama");
        }
    }

    $query = "UPDATE mahasiswa SET nama = '$nama', nrp = '$nrp', email = '$email', jurusan = '$jurusan', gambar = '$gambar' WHERE id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function upload()
{

    $name = $_FILES['gambar']['name'];
    $full_path = $_FILES['gambar']['full_path'];
    $type = $_FILES['gambar']['type'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $error = $_FILES['gambar']['error'];
    $size = $_FILES['gambar']['size'];

    // cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "
            <script>
                alert('pilih gambar terlebih dahulu');
            </script>
        ";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $extensi_valid = ['jpg', 'jpeg', 'png'];
    $extensi_gambar = explode('.', $name);
    $extensi_gambar = strtolower(end($extensi_gambar));
    if (!in_array($extensi_gambar, $extensi_valid)) {
        echo "
            <script>
                alert('yang anda upload bukan gambar');
            </script>
        ";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if ($size > 1000000) {
        echo "
            <script>
                alert('ukuran gambar terlalu besar');
            </script>
        ";
        return false;
    }

    // lolos pengecekan, gambar siap diupload
    // generate nama gambar baru
    $new_name = uniqid();
    $new_name .= '.';
    $new_name .= $extensi_gambar;
    move_uploaded_file($tmp_name, "img/$new_name");
    return $new_name;
}

function registrasi($post)
{
    global $conn;

    $username = strtolower(stripslashes($post['username']));
    $password = mysqli_real_escape_string($conn, $post['password']);
    $password2 = mysqli_real_escape_string($conn, $post['password2']);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo '
            <script>
                alert("username sudah terdaftar");
            </script>
        ';
        return false;
    }

    if ($password !== $password2) {
        echo '
            <script>
                alert("konfirmasi password tidak sesuai");
            </script>
        ';
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan userbaru ke database
    $query = "INSERT INTO user VALUES('', '$username', '$password')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
