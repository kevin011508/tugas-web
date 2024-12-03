<?php
session_start();

// Cek apakah $_SESSION['keranjang'] sudah didefinisikan
if (!isset($_SESSION['keranjang']) || !is_array($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array(); // Inisialisasi dengan array kosong jika belum ada
}

$koneksi = new mysqli("localhost", "root", "", "caffe_nova");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="" />
<meta name="author" content="" />
<title>Keranjang Belanja</title>
<!-- Favicon-->
<link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
<!-- Bootstrap icons-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
<!-- Core theme CSS (includes Bootstrap)-->
<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Caffe Nova</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index.php">All Products</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="#">Makanan</a></li>
                            <li><a class="dropdown-item" href="podmod.php">Minuman</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                    <a href="profil.php" class="btn btn-outline-light me-2">
                        <i class="fa-solid fa-user"></i>
                    </a>
                    <button class="btn btn-outline-light" type="submit" formaction="keranjang.php">
                        <i class="bi-cart-fill me-1"></i>
                        <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo count($_SESSION['keranjang']); ?></span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <section class="konten py-5">
        <div class="container">
            <h1 class="mb-4">Checkout</h1>
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>SubHarga</th>

                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no = 1; 
                    $totalBelanja = 0; 
                    if (isset($_SESSION['keranjang']) && is_array($_SESSION['keranjang'])): 
                        foreach ($_SESSION['keranjang'] as $id => $jumlah) {
                            $ambil = $koneksi->query("SELECT * FROM produk WHERE id='$id'");
                            $pecah = $ambil->fetch_assoc();
                            if ($pecah) {
                                $harga = isset($pecah['harga']) ? $pecah['harga'] : 0;
                                $subHarga = $harga * $jumlah;
                                $totalBelanja += $subHarga;

                                // Pastikan foto adalah string dan bukan array
                                $foto = isset($pecah['foto']) ? $pecah['foto'] : '';
                            ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="img/<?php echo htmlspecialchars($pecah['foto']); ?>" height="100px" alt="" class="me-3 rounded">
                                    <span><?php echo htmlspecialchars($pecah['nama']); ?></span>
                                </div>
                            </td>
                            <td>Rp. <?php echo number_format($pecah['harga']); ?></td>
                            <td><?php echo htmlspecialchars($jumlah); ?></td>
                            <td>Rp. <?php echo is_numeric($pecah['harga']) && is_numeric($jumlah) ? number_format($pecah['harga'] * $jumlah) : '0'; ?></td>
                        
                        </tr>
                        <?php 
                            }
                        }
                    else: 
                    ?>
                    <tr>
                        <td colspan="5">Keranjang kosong</td>
                    </tr>
                    <?php endif; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="4">Total Belanja</th>
                        <th>Rp. <?php echo number_format($totalBelanja); ?></th>
                    </tr>
                </tfoot>
                </table>
            </div>

            <div class="d-flex justify-content-between">
                <a href="keranjang.php" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-left"></i> Lanjutkan belanja
                </a>
                <a href="cetak.php" class="btn btn-primary">
                    Beli <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>
</html>