<?php
    require "koneksi.php";

    $nama = htmlspecialchars($_GET['nama']);
    $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama='$nama'");
    $produk = mysqli_fetch_array($queryProduk);

    $queryProdukTerkait = mysqli_query($con , "SELECT * FROM produk WHERE kategori_id='$produk[kategori_id]'
     AND id!='$produk[id]' LIMIT 4");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Detail Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"?>

    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-5">
                    <img src="image/<?=$produk['foto']?>" alt="" class="w-100">
                    <div class="col-lg-6 offset-lg-1">
                        <h1><?= $produk['nama']?></h1>
                        <div class="fs-5">
                            <p><?=$produk['detail']?></p>
                            <p class="text-harga">Rp. <?=$produk['harga']?></p>
                            <div class="fs-5">
                                Status Ketersediaan : <strong><?=$produk['ketersediaan_stok']?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PRODUK TERKAIT -->

    <div class="container-fluid py-5 warna3">
        <div class="container">
            <h2 class="text-center text-white mb-5">Produk Terkait</h2>
        <?php while($data=mysqli_fetch_array($queryProdukTerkait)):?>
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="produk_detaill\.php?nama="<?= $data['nama']?>>
                        <img src="image/<?=$data['foto']?>" class="img-fluid img-thumbnail produk-terkait-image" alt="">
                    </a>
                </div>
            </div>
            <?php endwhile;?>
        </div>
    </div>

        <!-- FOOTER -->
        <?php require "footer.php"?>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>