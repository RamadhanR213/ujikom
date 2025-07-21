<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['log']) || $_SESSION['role'] != 'member') {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];
$query = mysqli_query($conn, "SELECT * FROM pendaftar WHERE id = '$id_user'");
$data = mysqli_fetch_assoc($query);

// Proses update data
if (isset($_POST['update'])) {
    $username   = $_POST['username'];
    $email      = $_POST['email'];
    $dateofbirth        = $_POST['dateofbirth'];
    $gender     = $_POST['gender'];
    $address    = $_POST['address'];
    $city       = $_POST['city'];
    $contact    = $_POST['contact'];
    $paypal     = $_POST['paypal'];
    $password   = $_POST['password'];

    if (!empty($password)) {
        // Jika user mengisi password, hash dan update password juga
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $update = mysqli_query($conn, "UPDATE pendaftar SET 
    username='$username', email='$email', dateofbirth='$dateofbirth', gender='$gender',
    address='$address', city='$city', contact='$contact', paypal='$paypal',
    assword='$hashed_password'
     WHERE id='$id_user'");
    } else {
        // Jika tidak mengisi password, update data tanpa mengubah password
    $update = mysqli_query($conn, "UPDATE pendaftar SET 
    username='$username', email='$email', dateofbirth='$dateofbirth', gender='$gender',
    address='$address', city='$city', contact='$contact', paypal='$paypal'
    WHERE id='$id_user'");
    }


    if ($update) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='account.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Shop</title>
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="assets/style.css" />
</head>
<body>
    <section id="navbar">
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
      <div class="container-fluid">
        <img
          src="assets/image/icon-healthier.png"
          alt="Logo"
          style="width: 50px; height: 50px; margin: 10px"
          class="d-inline-block align-text-top" />
        <a class="navbar-brand mx-2" href="index.php">Health Shop</a>

        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div
          class="collapse navbar-collapse justify-content-end mr-3"
          id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="belanja.php">Belanja</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="cart.php?p=0">Keranjang</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="https://wa.me/+6281240277417">Kontak Kami</a>
            </li>
          </ul>
          <ul class="navbar-nav mx-4">
            <?php
            if (!isset($_SESSION['log'])) {
              echo '
					<li><a href="register.php" class="btn btn-light mx-2"> Register</a></li>
					<li><a href="login.php" class="btn btn-light">Login</a></li>
					';
            } else {

              if ($_SESSION['role'] == 'member') {
                echo '
                    <li><a href="account.php" class="btn btn-light mx-2">Account</a></li>
					<li><a href="logout.php" class="btn btn-light mb-1">Logout</a></li>
					';
              } else {
                echo '
					<li><a href="admin" class="btn btn-light mb-1 mx-3">Admin</a></li>
					<li><a href="logout.php" class="btn btn-light mb-1">Logout</a></li>
					';
              };
            }
            ?>
          </ul>
        </div>
      </div>
    </nav>
  </section>

  <div class="container mt-5">
    <h3>Edit Akun</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['username']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" placeholder="Isi jika ingin mengubah">
        </div>

        <div class="mb-3">
            <label>E-mail:</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Date of birth:</label>
            <input type="date" name="dateofbirth" class="form-control" value="<?= htmlspecialchars($data['dateofbirth']) ?>">
        </div>

        <div class="mb-3">
            <label>Gender:</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="Male" <?= ($data['gender'] == 'Male') ? 'checked' : '' ?>>
                <label class="form-check-label">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="Female" <?= ($data['gender'] == 'Female') ? 'checked' : '' ?>>
                <label class="form-check-label">Female</label>
            </div>
        </div>

        <div class="mb-3">
            <label>Address:</label>
            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($data['address']) ?>">
        </div>

        <div class="mb-3">
            <label>City:</label>
            <input type="text" name="city" class="form-control" value="<?= htmlspecialchars($data['city'])?>">
        </div>

        <div class="mb-3">
            <label>Contact:</label>
            <input type="text" name="contact" class="form-control" value="<?= htmlspecialchars($data['contact']) ?>">
        </div>

        <div class="mb-3">
            <label>Paypal ID:</label>
            <input type="text" name="paypal" class="form-control" value="<?= htmlspecialchars($data['paypal']) ?>">
        </div>

        <button type="submit" name="update" class="btn btn-success">Simpan Perubahan</button>
        <a href="account.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

    

    <?php include('footer.php') ?>


  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>