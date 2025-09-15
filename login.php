<?php
session_start();
include 'koneksi.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $cekdb = mysqli_query($conn,"SELECT * FROM pendaftar WHERE username='$username'");
    $row = mysqli_fetch_assoc($cekdb);

    if($row && password_verify($password, $row['password'])){
        // simpan session login
        $_SESSION['log'] = true;
        $_SESSION['id'] = $row['id'];            // id user
        $_SESSION['username'] = $row['username']; // username
        $_SESSION['role'] = $row['role'];         // role user

        // redirect ke dashboard atau index
        header('location:index.php');
        exit;
    } else {
        echo "<div class='alert alert-danger' style='position: fixed; z-index: 1000'>
                Username atau Password salah!
              </div>
              <meta http-equiv='refresh' content='1; url= login.php'/> ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - MedShop</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <style>
    *{
      margin:0;
      padding:0;
      box-sizing:border-box;
      font-family: 'Poppins', sans-serif;
    }
    body{
      display:flex;
      justify-content:center;
      align-items:center;
      min-height:100vh;
      background: linear-gradient(135deg,#71b7e6,#9b59b6);
    }
    .wrapper{
      position:relative;
      width:350px;
      background:#fff;
      border-radius:20px;
      padding:40px;
      box-shadow:0 15px 25px rgba(0,0,0,0.1);
      overflow:hidden;
      animation: show 0.5s ease;
    }
    @keyframes show {
      from { transform: translateY(40px); opacity:0; }
      to { transform: translateY(0); opacity:1; }
    }
    .wrapper h2{
      text-align:center;
      margin-bottom:20px;
      color:#333;
    }
    .input-box{
      position:relative;
      width:100%;
      margin-bottom:20px;
    }
    .input-box input{
      width:100%;
      padding:12px 15px;
      background:#f0f0f0;
      border:none;
      outline:none;
      border-radius:10px;
      font-size:14px;
    }
    .btn{
      width:100%;
      padding:12px;
      border:none;
      border-radius:10px;
      background:#9b59b6;
      color:#fff;
      font-weight:600;
      cursor:pointer;
      transition:0.3s;
    }
    .btn:hover{
      background:#8e44ad;
    }
    .link{
      text-align:center;
      margin-top:15px;
      font-size:14px;
    }
    .link a{
      color:#9b59b6;
      text-decoration:none;
      font-weight:600;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <h2>Login</h2>
    <form action="login.php" method="POST">
      <div class="input-box">
        <input type="text" name="username" placeholder="Username" required>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <button type="submit" name="login" class="btn">Login</button>
      <div class="link">
        Belum punya akun? <a href="register.php">Register</a>
      </div>
    </form>
  </div>
</body>
</html>
