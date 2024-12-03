<?php
// Memulai sesi dan menghubungkan ke database
include "koneksi.php";
session_start();

// Inisialisasi keranjang belanja jika belum ada
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Cafe Nova - Shop makanan dan minuman">
    <meta name="author" content="Cafe Nova">
    <title>Cafe Nova - Online Store</title>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Core CSS (includes Bootstrap) -->
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/custom.css">
    <style>
        .navbar {
            transition: background-color 0.3s;
        }
        .navbar:hover {
            background-color: #333;
        }
        .product-img {
            transition: transform 0.5s;
        }
        .product-img:hover {
            transform: scale(1.1);
        }
        .btn-dark {
            background-color: #5a5a5a;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-dark:hover {
            background-color: #333;
        }
        .card:hover {
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        .rating {
            color: #f8d64e;
        }
        .card-footer {
            background-color: rgba(0, 0, 0, 0.03);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand text-white" href="#!">Cafe Nova</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active text-white" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="keranjang.php">Keranjang</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index.php">All Products</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="detail.php">Makanan</a></li>
                            <li><a class="dropdown-item" href="detail2.php">Minuman</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                    <a href="profil.php" class="btn me-2 bg-white">
                        <i class="fa-solid fa-user"></i>
                    </a>
                    <button class="btn bg-white" type="submit" formaction="keranjang.php">
                        <i class="bi-cart-fill me-1"></i>
                        <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo count($_SESSION['cart']); ?></span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Section -->
    <main class="container my-5 p-4 bg-white shadow-lg rounded-lg">
        <div class="row">
            <?php
            // Mengambil data produk berdasarkan ID dari URL
            $id = $_GET['id'];
            $query = "SELECT * FROM produk WHERE id=$id";
            $hasil = mysqli_query($koneksi, $query);

            while ($produk = mysqli_fetch_array($hasil)) {
            ?>
            <div class="col-md-6">
                <img src="img/<?php echo $produk['foto']; ?>" alt="<?php echo $produk['nama']; ?>" class="img-fluid product-img rounded shadow">
            </div>
            <div class="col-md-6">
                <form action="keranjang.php?id=<?= $produk['id']; ?>" method="post">
                    <h2 class="font-weight-bold mb-4"><?php echo $produk['nama']; ?></h2>
                    <p class="text-muted mb-4"><?php echo $produk['deskripsi']; ?></p>
                    <p><i class="bi bi-star-fill text-warning"></i> <i class="bi bi-star-fill text-warning"></i> <i class="bi bi-star-fill text-warning"></i> <i class="bi bi-star-fill text-warning"></i> <i class="bi bi-star-half text-warning"></i></p>
                    <p class="font-weight-bold">Harga: Rp <?php echo number_format($produk['harga']); ?></p>

                    <div class="mb-4">
                        <label for="jumlah" class="form-label">Jumlah:</label>
                        <input type="number" id="jumlah" name="jumlah" value="1" min="1" class="form-control w-25">
                    </div>

                    <input type="hidden" name="nama" value="<?php echo $produk['nama']; ?>">
                    <input type="hidden" name="harga" value="<?php echo $produk['harga']; ?>">
                    <input type="hidden" name="foto" value="<?php echo $produk['foto']; ?>">

                    <a href="produk.php" class="btn btn-outline-primary">Kembali</a>
                    <button type="submit" name="add" class="btn btn-dark">Tambah ke Keranjang</button>
                </form>
            </div>
            <?php } ?>
        </div>
    </main>

    <!-- Produk Terkait Section -->
    <div class="container-fluid py-5 bg-light text-center">
        <h2 class="text-black mb-5">PRODUK TERKAIT</h2>
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                // Menampilkan produk terkait
                $tambah = mysqli_query($koneksi, "SELECT * FROM produk WHERE kategori='minuman'");
                while ($produk = mysqli_fetch_array($tambah)) {
                ?>
                <div class="col mb-5">
                    <div class="card h-100 shadow-sm">
                        <img class="card-img-top product-img" src="img/<?= $produk['foto']; ?>" alt="<?= $produk['nama']; ?>">
                        <div class="card-body p-4 text-center">
                            <h5 class="card-title"><?= $produk['nama']; ?></h5>
                            <p class="card-text"><?= $produk['deskripsi']; ?></p>
                            <p class="font-weight-bold">Rp. <?php echo number_format($produk['harga']); ?></p>
                            <p class="rating">★★★★☆</p>
                        </div>
                        <div class="card-footer text-center bg-transparent">
                            <a href="detail.php?id=<?= $produk['id']; ?>" class="btn btn-outline-dark">Detail</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Cafe Nova 2023</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
</body>
</html>
        