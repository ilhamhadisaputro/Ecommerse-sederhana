<?php
require "koneksi.php";
$queryProduk =mysqli_query($con, "SELECT id,nama,harga,foto,detail FROM produk LIMIT 6");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"?>

    <!-- ==Banner== -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Toko Online</h1>
            <h3>Mau cari apa</h3>
                <div class="col-md-8 offset-md-2">
                    <form action="produk.php" method="get">
                        <div class="input-group my-4">
                            <div class="input-group input-group-lg mb-3">
                                <input type="text" name="keyword" class="form-control" placeholder="Nama Barang" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <button type="submit" class="btn warna2 text-white" name="btnTelusuri">Telusuri</button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>

        <!-- ====  hightlight kategori  ==== -->
        <div class="container-fluid py-5">
            <div class="container text-center">
                <h3>Kategori Terlaris</h3>

                <div class="row mt-5 list">
                    <div class="col-md-4 mb-3 list-group">
                        <a href="produk.php?kategori=headset">
                            <div class="highlight-kategori kategori-headset d-flex justify-content-center align-items-center">
                                <h4 class="text-white">Headset</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3 list-group">
                        <a href="produk.php?kategori=pc">
                            <div class="highlight-kategori kategori-pc-game d-flex justify-content-center align-items-center">
                                <h4 class="text-white">PC Gaming</h4>
                            </div>
                        </a>
                        
                    </div>
                    <div class="col-md-4 mb-3 list-group">
                        <a href="produk.php?kategori=router">
                            <div class="highlight-kategori jaringan d-flex justify-content-center align-items-center">
                                <h4 class="text-white">Router</h4>
                            </div>
                        </a>
                        
                    </div>
                </div>

            </div>
        </div>

        <!-- TENTANG KAMI -->
        <div class="container-fluid warna3 py-5">
            <div class="container text-center">
                <h3>Tentang Kami</h3>
                <p class="fs-5 mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia consectetur sunt totam dolorum consequatur eos quod ea animi voluptates ipsa.</p>
            </div>
        </div>

        <!-- PRODUK -->

        <div class="container-fluid py-5">
            <div class="container text-center">
                <h3>produk</h3>

                <div class="row mt-5">
                    <?php while($data=mysqli_fetch_array($queryProduk)):?>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <div class="card h-100" style="">
                        <div class="image-box">
                            <img src="image/<?=$data['foto']?>" class="card-img-top" alt="...">
                        </div>
                            <div class="card-body">
                                <h4 class="card-title"><?= $data['nama']?></h4>
                                <p class="card-text text-truncate"><?= $data['detail']?></p>
                                <p class="card-text text-harga">Rp.<?=$data['harga']?></p>
                                <a href="produk_detail.php?nama=<?=$data['nama']?>" class="btn text-white warna3">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php endwhile;?>
                </div>
                <a class="btn btn-outline-primary mt-4" href="produk.php">See More</a>
            </div>
        </div>


        <!-- FOOTER -->
        <?php require "footer.php"?>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>