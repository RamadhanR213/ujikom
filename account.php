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
    $dateofbirth = $_POST['dateofbirth'];
    $gender     = $_POST['gender'];
    $address    = $_POST['address'];
    $city       = $_POST['city'];
    $contact    = $_POST['contact'];
    $paypal     = $_POST['paypal'];
    $password   = $_POST['password'];

    // handle foto profil
    $foto = $data['foto']; 
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        if (!is_dir("assets/uploads")) {
            mkdir("assets/uploads", 0777, true);
        }

        $foto_name = time() . "_" . basename($_FILES['foto']['name']);
        $target = "assets/uploads/" . $foto_name;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
            $foto = $foto_name;
        }
    }

    if (!empty($password)) {
        // Jika user mengisi password, hash dan update password juga
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update = mysqli_query($conn, "UPDATE pendaftar SET 
            username='$username', email='$email', dateofbirth='$dateofbirth', gender='$gender',
            address='$address', city='$city', contact='$contact', paypal='$paypal',
            password='$hashed_password', foto='$foto'
            WHERE id='$id_user'");
    } else {
        // Jika tidak mengisi password, update data tanpa mengubah password
        $update = mysqli_query($conn, "UPDATE pendaftar SET 
            username='$username', email='$email', dateofbirth='$dateofbirth', gender='$gender',
            address='$address', city='$city', contact='$contact', paypal='$paypal', foto='$foto'
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
  <title>Medshop</title>
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <link rel="stylesheet" href="assets/style.css" />
  <style>
    .profile-pic {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid #007bff;
    }
    .edit-label {
      cursor: pointer;
      display: block;
      margin-top: 10px;
      font-size: 14px;
      color: #007bff;
      text-decoration: underline;
    }
     .navbar {
      background: linear-gradient(90deg, #0d6efd, #084298);
    }
    .navbar-brand, .nav-link, .btn {
      font-weight: 500;
    }
  </style>
</head>
<body>
 <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <img src="assets/image/profile.jpg" alt="Logo" style="width: 50px; height: 50px;" class="d-inline-block align-text-top" />
      <a class="navbar-brand mx-2" href="index.php">MedShop</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="belanja.php">Belanja</a></li>
          <li class="nav-item"><a class="nav-link" href="cart.php?p=0">Keranjang</a></li>
          <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak Kami</a></li>
        </ul>
        <ul class="navbar-nav mx-4">
          <?php
          if (!isset($_SESSION['log'])) {
            echo '
              <li><a href="register.php" class="btn btn-light mx-2">Register</a></li>
              <li><a href="login.php" class="btn btn-outline-light">Login</a></li>
            ';
          } else {
            if ($_SESSION['role'] == 'member') {
              echo '
                <li><a href="account.php" class="btn btn-light mx-2">Account</a></li>
                <li><a href="logout.php" class="btn btn-outline-light">Logout</a></li>
              ';
            } else {
              echo '
                <li><a href="admin" class="btn btn-light mx-3">Admin</a></li>
                <li><a href="logout.php" class="btn btn-outline-light">Logout</a></li>
              ';
            }
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>


<div class="container mt-5">
  <h3>Edit Akun</h3>
  <form method="POST" enctype="multipart/form-data">
    <div class="text-center mb-4">
      <img src="<?= !empty($data['foto']) ? 'assets/uploads/' . $data['foto'] : 'assets/image/default.png' ?>" 
           alt="Foto Profil" class="profile-pic">
      <label for="foto" class="edit-label">Edit Foto</label>
      <input type="file" id="foto" name="foto" class="d-none" accept="image/*">
    </div>

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

  <?php
  $user_id = $_SESSION['id'];
  $pembayaran = mysqli_query($conn, "SELECT * FROM pembayaran WHERE user_id='$user_id'");
  ?>

  <h4 class="mt-5">Metode Pembayaran Anda</h4>
  <table class="table table-bordered">
    <tr>
      <th>Metode</th>
      <th>Nomor</th>
      <th>Atas Nama</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($pembayaran)) { ?>
    <tr>
      <td><?= $row['metode']; ?></td>
      <td><?= $row['nomor']; ?></td>
      <td><?= $row['atas_nama']; ?></td>
    </tr>
    <?php } ?>
  </table>

  <a href="add_pembayaran.php" class="btn btn-success">Tambah Metode Pembayaran</a>
</div>

<?php include('footer.php') ?>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
