<?php
include "koneksi.php";
session_start();

$total = 0;

$id_user = $_SESSION['id_user'];;

if(isset($id_user)) {
  

  if (isset($_POST['add'])){
    if (isset($id_user)){


      if(isset($_SESSION['cart'])){
      
        $item_array_id = array_column($_SESSION['cart'], 'id');
      if(!in_array($_GET["id"], $item_array_id)){
        $count = count($_SESSION['cart']);
        $item_array =array(
         'id' => $_GET['id'],
         'nama' => $_POST['nama'],
         'harga' => $_POST['harga'],
         'foto' => $_POST['foto'],
         'jumlah' => $_POST['jumlah'],
        );
        $_SESSION['cart'] [$count] = $item_array;
        echo "<script>";
      }else {
        echo"<script>
        alert('berhasil dimasukan ke keranjang');
        </script>";
      }
      }else {
        echo"<script>
        alert('sudah ada di keranjang');
        </script>";
      }
    }else {
      $item_array = array(
        'id' => $_GET['id'],
        'nama' => $_POST['nama'],
        'harga' => $_POST['harga'],
        'foto' => $_POST['foto'],
        'jumlah' => $_POST['jumlah'],
      );
      $_SESSION['cart'] [0] = $item_array;
      echo"<script>
      alert('berhasil dimasukan ke keranjang');
      </script>";
    }
  }
}
if(isset($_GET['aksi'])){
  if($_GET['aksi'] == 'hapus')(
    
  );
}
?>
