<?php
session_start();
if(!isset($_SESSION['log'])){
	
} else {
	header('location:index.php');
};
include 'koneksi.php';

if(isset($_POST['adduser']))
	{
    $username = $_POST["username"];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $email = $_POST["email"];
    $dateofbirth = $_POST["dateofbirth"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $contact = $_POST["contact"];
    $paypal = $_POST["paypal"];
			  
		$tambahuser = mysqli_query($conn,"INSERT INTO pendaftar (username, password, email, dateofbirth, gender, address, city, contact, paypal)
 VALUES ('$username', '$password','$email', '$dateofbirth', '$gender', '$address', '$city', '$contact', '$paypal')");
		if ($tambahuser){
		echo " <div class='alert alert-success' style='position: fixed; z-index: 1000'>
			Berhasil mendaftar, silakan masuk.
		  </div>
		<meta http-equiv='refresh' content='1; url= login.php'/>  ";
		} else { echo "<div class='alert alert-warning' style='position: fixed; z-index: 1000' >
			Gagal mendaftar, silakan coba lagi.
		  </div>
		 <meta http-equiv='refresh' content='1; url= register.php'/> ";
		}
		
	};
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - MedShop</title>
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
      width:400px;
      height:auto;
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
    .input-box input, 
    .input-box select{
      width:100%;
      padding:12px 15px;
      background:#f0f0f0;
      border:none;
      outline:none;
      border-radius:10px;
      font-size:14px;
    }
    .gender-box{
      display:flex;
      justify-content: space-around;
      margin-bottom:20px;
      color:#333;
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
  <script>
    function validateForm() {
      const password = document.querySelector('input[name="password"]').value;
      const rePassword = document.querySelector('input[name="re-password"]').value;
      if (password !== rePassword) {
        alert("Password tidak sama!");
        return false;
      }
      return true;
    }
  </script>
</head>
<body>
  <div class="wrapper">
    <h2>Register</h2>
    <form action="register.php" method="POST" onsubmit="return validateForm()">
      <div class="input-box">
        <input type="text" name="username" placeholder="Username" required>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <div class="input-box">
        <input type="password" name="re-password" placeholder="Confirm Password" required>
      </div>
      <div class="input-box">
        <input type="email" name="email" placeholder="Email" required>
      </div>
      <div class="input-box">
        <input type="date" name="dateofbirth" required>
      </div>
      <div class="gender-box">
        <label><input type="radio" name="gender" value="male" required> Male</label>
        <label><input type="radio" name="gender" value="female"> Female</label>
      </div>
      <div class="input-box">
        <input type="text" name="address" placeholder="Address" required>
      </div>
      <div class="input-box">
        <select name="city" required>
          <option value="">Select City</option>
          <option value="Surabaya">Surabaya</option>
          <option value="Kediri">Kediri</option>
          <option value="Sidoarjo">Sidoarjo</option>
          <option value="Jombang">Jombang</option>
          <option value="Mojokerto">Mojokerto</option>
          <option value="Gresik">Gresik</option>
        </select>
      </div>
      <div class="input-box">
        <input type="number" name="contact" placeholder="Contact Number" required>
      </div>
      <div class="input-box">
        <input type="text" name="paypal" placeholder="Paypal ID" required>
      </div>
      <button type="submit" name="adduser" class="btn">Register</button>
      <div class="link">
        Sudah punya akun? <a href="login.php">Login</a>
      </div>
    </form>
  </div>
</body>
</html>
