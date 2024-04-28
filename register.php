<?php
include_once("koneksi.php");
include_once("index.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi konfirmasi password
    if ($password != $confirm_password) {
        echo "<script>alert('Konfirmasi password tidak sesuai!');</script>";
    } else {
        // Enkripsi password menggunakan MD5
        $hashed_password = md5($password);

        // Insert data pengguna ke dalam tabel pengguna
        $sql = "INSERT INTO pengguna (username, password) VALUES ('$username', '$hashed_password')";
        if ($mysqli->query($sql) === TRUE) {
            echo "<script>alert('Registrasi berhasil!');</script>";
            // Redirect ke halaman login setelah registrasi berhasil
            header("Location: login.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap Online -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">   
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Register</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary" name="register">Register</button>
    </form>
</div>

</body>
</html>
