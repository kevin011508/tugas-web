<?php

session_start();
$id = $_GET["id"];

unset($_SESSION['keranjang'][$id]);
echo "<script>alert('produk berhasil dihapus dari keranjang');</script>";
echo "<script>window.location='keranjang.php';</script>";
?>