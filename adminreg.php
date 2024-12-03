<?php
include 'koneksi.php';

if(isset($_POST['masuk'])){
    $username = $_POST['username'];    
    $password = $_POST['password'];
    $masuk = mysqli_query($koneksi,"INSERT INTO user(username,password)
     VALUES('$username','$password')" );
     if($masuk > 0){
        header("location: loginadmin.php");
     }else{
        header("location: adminreg.php");

     }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Sign Up Form</title>
<style>
body {
  font-family: sans-serif;
}

.container {
  width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ddd;
}

h2 {
  text-align: center;
  margin-bottom: 20px;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="number"] {
  width: 100%;
  padding: 10px;
  margin: 5px 0;
  border: 1px solid #ddd;
  box-sizing: border-box;
}

input[type="checkbox"] {
  margin-right: 5px;
}

button {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  margin: 10px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.9;
}

a {
  color: #4CAF50;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}
</style>
</head>
<body>
<div class="container">
<h2>Sign Up</h2>
<form method="POST" enctype="multipart/form-data">
  <div>
    <label for="username">Username:</label>
    <input type="text" id="text" name="username" placeholder="Username">
  </div>
  <div>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" placeholder="password">
  </div>
    <input type="checkbox" id="agree-terms" name="agree-terms">
    <label for="agree-terms">I agree to the Terms of User</label>
  </div>
  <button type="submit" name="masuk">Sign Up</button>
</form>
</div>
</body>
</html>