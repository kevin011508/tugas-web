//koneksi

<?php 
$koneksi = mysqli_connect("localhost","root","","cafe_nova");
?>

//login

<?php
include 'koneksi.php';
if(isset($_POST[$login])){
  $username =$_POST['username'];
  $password =$_POST['password'];
  $login = mysqli_query(
    $koneksi,"SELECT * FROM user where ussernme='$username' and password='$password'"
  );
  if(mysqli_num_rows($login)>0);{
    header("locatioon;index.php");
  }

}
?>

//regis
<?php
include 'koneksi.php';
session_start();
if(isset($_POST['sumbit'])){
 $name =$_POST ['name'];
 $username =$_POST ['username'];
 $password =$_POST ['password'];
 $emai =$_POST ['email'];
 $no_hp =$_POST ['no_hp'];
 $alamat =$_POST ['alamat'];
 if($nama && $username && $password && $email) {
    $simpan = mysqli_query($koneksi,"INSERT INTO tb_user(nama,username,password,email,no_hp,alamat,role)
    VALUES('$nama','$usernamme','$password','$emai','$no_hp','$alamat','pelangan')");
    if($simpan){
        header("location:login.php");
    }
 }else("lengkapi data");
}
?>

//hapus

<?php
include "koneksi.php";

$id = $_GET['id'];

$squery = mysqli_query($koneksi,"DELETE FROM produk where id = $id");
header('location: dashboard.php');
?>