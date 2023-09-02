<?php
    require "session.php";
    require "../koneksi.php";

    $queryKategori= mysqli_query($con, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);
    $queryProduk= mysqli_query($con, "SELECT * FROM produk");
    $jumlahProduk = mysqli_num_rows($queryProduk);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<style>
    .summary-kategori{
        background-color: #0a6b4a;
        border-radius: 10px;
    }
    .summary-produk{
        background-color: blue;
        border-radius: 10px;
    }
    .none-decoraiton{
        text-decoration: none;
        color:white;
    }
    .none-decoraiton:hover{
        color:blue;
    }
</style>
<body>
    <?php 
        require "navbar.php";
    ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-house"></i>Home</li>
            </ol>
        </nav>
        <h3>Hallo <?=$_SESSION['username'];?></h3>

        <div class="container mt-5 ">
            <div class="row">
                <div class="col-lg-4 col-md-6 kotak p-4">
                    <div class="summary-kategori p-3">
                        <div class="row">
                            <div class="col-6 col-md-6">
                                <i class="bi bi-justify text-black-50" style="font-size: 4rem;"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Kategori</h3>
                                <p class="fs-4"><?= $jumlahKategori?></p>
                                <p><a href="kategori.php"  class="none-decoraiton">Lihat detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 kotak p-4">
                    <div class="summary-produk p-3">
                    <div class="row">
                            <div class="col-6 ">
                                <i class="bi bi-box2-fill text-black-50" style="font-size: 4rem;"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Produk</h3>
                                <p class="fs-4"><?= $jumlahProduk?></p>
                                <p><a href="produk.php"  class="none-decoraiton">Lihat detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>