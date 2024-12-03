<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['pelanggan'])) {
    header('Location: login.php');
    exit();
}

// Get customer details from session
$user = $_SESSION['pelanggan'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }
        .navbar {
            border-bottom: 1px solid #eaeaea;
        }
        .profile-card {
            margin-top: 40px;
            border-radius: 15px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .profile-card .card-header {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .profile-card .card-body {
            padding: 30px;
        }
        .profile-card .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 5px solid #343a40;
        }
        .profile-card .form-control-plaintext {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 10px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-outline-dark {
            border-color: #343a40;
            color: #343a40;
        }
        .btn-outline-dark:hover {
            background-color: #343a40;
            color: #fff;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand text-white" href="#!">Cafe Nova</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent" >
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item "><a class="nav-link active text-white" aria-current="page" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="keranjang.php">Keranjang</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="index.php">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="detail.php">Makanan</a></li>
                                <li><a class="dropdown-item" href="detail2.php">Minuman</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <a href="profil.php" class="btn  me-2 bg-white">
                            <i class="fa-solid fa-user"></i> 
                        </a>
                        <button class="btn bg-white" type="submit" formaction="keranjang.php">
                            <i class="bi-cart-fill me-1"></i>
                            
                            <span class="badge bg-dark text-white ms-1 rounded-pill"></span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

    <div class="container">
        <div class="profile-card mx-auto" style="max-width: 600px;">
            <div class="card-header">
                <h2>User Profile</h2>
            </div>
            <div class="card-body text-center">
                <img src="./img/coffe.jpg.jpg" alt="User Avatar" class="avatar">
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input type="text" class="form-control-plaintext" readonly value="<?php echo isset($_SESSION['pelanggan']) ? htmlspecialchars($_SESSION['pelanggan']) : 'Pelanggan tidak tersedia'; ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="text" class="form-control-plaintext" readonly value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Pelanggan tidak tersedia'; ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone Number:</label>
                    <input type="text" class="form-control-plaintext" readonly value="<?php echo isset($_SESSION['hp']) ? htmlspecialchars($_SESSION['hp']) : 'Pelanggan tidak tersedia'; ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Address:</label>
                    <input type="text" class="form-control-plaintext" readonly value="<?php echo isset($_SESSION['alamat']) ? htmlspecialchars($_SESSION['alamat']) : 'Pelanggan tidak tersedia'; ?>">
                </div>
                <a href="index.php" class="btn btn-primary">Back to Home</a>
                <a href="log-out.php" class="btn btn-danger">logout</a>
                
                <!-- <a  href='profil.php?aksi=edit&id=" . $tb_user['id']. "' class='btn btn-primary btn-sm'>EDIT PROFIL</a> -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>