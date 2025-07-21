<?php
session_start();
if (isset($_SESSION['log'])) {
    header('location:index.php');
    exit();
}

include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST["username"];
    $password = $_POST["password"]; // Tidak perlu hash password di sini

    $loginuser = mysqli_query($conn, "SELECT * FROM pendaftar WHERE username = '$username'");
    $searchuser = mysqli_fetch_assoc($loginuser);

    if ($searchuser && password_verify($password, $searchuser["password"])) {
        $_SESSION["id"] = $searchuser["id"];
        $_SESSION["username"] = $searchuser["username"];
        $_SESSION["role"] = $searchuser["role"];
        $_SESSION["log"] = "Logged";

        echo " <div class='alert alert-success text-center' style='position:;'>
			Berhasil login, selamat datang!.
		  </div>
		<meta http-equiv='refresh' content='1; url= index.php'/>  ";
    } else {
      echo " <div class='alert alert-warning text-center' style='position:'>
			Data salah, silakan login dengan data yang benar!.
		  </div>
		<meta http-equiv='refresh' content='1; url= login.php'/>  ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="assets/style.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"/>
    <title>Login Page</title>
</head>
<body>
<section id=navbar>
      <div>
      <nav class="navbar navbar-expand-lg bg-primary"  data-bs-theme="dark">
        <div class="container-fluid">
          <img
            src="assets/image/icon-healthier.png"
            alt="Logo"
            style="width: 50px; height: 50px; margin: 10px"
            class="d-inline-block align-text-top"
          />
          <a class="navbar-brand mx-2" href="index.php
          ">Health Shop</a>
          <div
            class="collapse navbar-collapse justify-content-end mr-3"
            id="navbarNav"
          >
          </div>
        </div>
      </nav>
      </div>
</section>
<section id="form">
  <div class="d-flex justify-content-center align-items-center" style="height: 90vh;">
        <div class="card container text-center shadow-lg" style="max-width: 600px;">
        <div class="pt-4">
          <img src="assets/image/icon-healthier.png" alt="Logo" style="width: 50px; height: 50px">
          <h5>Selamat datang di Health Shopr</h5>
      </div>
      <div>
          <form action="login.php" method="POST">
              <div>
                  Username :
                  <input class="box-input" type="text" name="username" required/>
              </div>
              <div>
                  Password :
                  <input class="box-input" type="password" name="password" required/>
              </div>
              <div style="margin-top: 15px">
                  <a style="display: flex; justify-content: center">
                      <button style="margin-right: 10px" type="submit" name="login" class="btn btn-primary">
                          Submit
                      </button>
                  </a>
              </div>
          </form>
        
      </div>
      <p class="mt-2 pb-4">Belum memiliki akun? <a href="register.php">Register</a></p>
  </div>
</section>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
