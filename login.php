<?php
// Include file koneksi ke database
include_once("koneksi.php");
include_once("index.php");

// Inisialisasi pesan error
$error = '';

// Cek jika formulir login dikirim
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Enkripsi password menggunakan MD5
    $hashed_password = md5($password);

    // Query untuk mencari pengguna berdasarkan username dan password
    $result = $mysqli->query("SELECT * FROM pengguna WHERE username='$username' AND password='$hashed_password'");

    // Check jika query menghasilkan hasil
    if($result->num_rows == 1) {
        // Pengguna ditemukan, atur sesi username dan redirect ke halaman utama
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        // Jika pengguna tidak ditemukan, tampilkan pesan error
        $error = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap Online -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">   
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Login</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary" name="login">Login</button>
    </form>
    <?php if($error != '') echo '<div class="alert alert-danger mt-3" role="alert">' . $error . '</div>'; ?>
</div>

</body>
</html>
