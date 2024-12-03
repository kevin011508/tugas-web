<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
$total = 0;
$id_user = $_SESSION['id_user'];

if (isset($id_user)) {
    if (isset($_POST['add'])) {
        $item_array_id = array_column($_SESSION['cart'], 'id');
        if (!in_array($_GET["id"], $item_array_id)) {
            $count = count($_SESSION['cart']);
            $item_array = array(
                'id' => $_GET['id'],
                'nama' => $_POST['nama'],
                'harga' => $_POST['harga'],
                'foto' => $_POST['foto'],
                'jumlah' => $_POST['jumlah'],
            );
            $_SESSION['cart'][$count] = $item_array;
            echo "<script>alert('Berhasil dimasukkan ke keranjang');</script>";
        } else {
            echo "<script>alert('Sudah ada di keranjang');</script>";
        }
    }

    if (isset($_GET['aksi'])) {
        if ($_GET['aksi'] == 'hapus') {
            foreach ($_SESSION['cart'] as $key => $value) {
                if ($value['id'] == $_GET['id']) {
                    unset($_SESSION['cart'][$key]);
                    echo "<script>alert('Produk dihapus dari keranjang');</script>";
                    echo "<script>window.location = 'keranjang.php';</script>";
                }
            }
        } elseif ($_GET['aksi'] == 'beli') {
            foreach ($_SESSION['cart'] as $key => $value) {
                $total += $value["jumlah"] * $value['harga'];
            }

            $query = mysqli_query($koneksi, "INSERT INTO tb_transaksi(tanggal, id_pelanggan, total_harga) VALUES ('" . date("Y-m-d") . "','$id_user','$total')");
            $id_transaksi = mysqli_insert_id($koneksi);

            foreach ($_SESSION['cart'] as $value) {
                $id_produk = $value['id'];
                $jumlah = $value['jumlah'];
                $sql = "INSERT INTO tb_detail(id_transaksi, id_produk, jumlah) VALUES ('$id_transaksi', '$id_produk', '$jumlah')";
                $res = mysqli_query($koneksi, $sql);

                if ($res) {
                    unset($_SESSION['cart']);
                    echo "<script>alert('Terima kasih sudah berbelanja');</script>";
                    echo "<script>window.location = 'nota.php?id=$id_transaksi';</script>";
                }
            }
        }
    }
} else {
    echo "<script>alert('Login dulu bro!');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Keranjang Belanja</title>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand text-white" href="#">Cafe Nova</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active text-white" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="keranjang.php">Keranjang</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">Shop</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php">All Products</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="detail.php">Makanan</a></li>
                        <li><a class="dropdown-item" href="detail2.php">Minuman</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex">
                <a href="profil.php" class="btn me-2 bg-white"><i class="fa-solid fa-user"></i></a>
                <button class="btn bg-white" type="submit" formaction="keranjang.php">
                    <i class="bi-cart-fill me-1"></i>
                    <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo count($_SESSION['cart']); ?></span>
                </button>
            </form>
        </div>
    </div>
</nav>

<main class="container mx-auto my-8 p-6 bg-gray-100 shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold mb-6">Keranjang Belanja</h2>
    <div class="space-y-6">
        <?php if (!empty($_SESSION['cart'])) { ?>
            <?php foreach ($_SESSION['cart'] as $value) { ?>
                <div class="bg-white p-4 shadow-sm rounded-lg flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <img src="img/<?php echo $value['foto'] ?>" alt="<?php echo $value['nama'] ?>" class="w-24 h-24 object-cover rounded-lg">
                        <div>
                            <h3 class="text-xl font-semibold"><?php echo $value['nama'] ?></h3>
                            <p class="text-gray-500">Jumlah: <?php echo $value['jumlah'] ?></p>
                            <p class="text-yellow-600 font-bold">Rp <?php echo number_format($value['harga'] * $value['jumlah'], 2) ?></p>
                        </div>
                    </div>
                    <a href="keranjang.php?aksi=hapus&id=<?php echo $value['id'] ?>" class="text-red-500 hover:text-red-700">Hapus</a>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p class="text-gray-500">Keranjang belanja kosong.</p>
        <?php } ?>
    </div>
    
    <div class="mt-8 text-right font-bold text-lg">
        Total: Rp <?php echo number_format($total, 2); ?>
    </div>

    <div class="mt-6 text-right">
        <a href="keranjang.php?aksi=beli" class="btn btn-primary px-6 py-2">Checkout</a>
    </div>
</main>

<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
</html>
