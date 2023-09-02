<?php
require "koneksi.php";

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

// 3Kali QUery
// Get produk by produk/keyword
    if(isset($_GET['keyword'])){
        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama LIKE '%$_GET[keyword]%'");
    }
// Get produk by kategori
    else if(isset($_GET['kategori'])){
        $queryGetKategoriId = mysqli_query($con , "SELECT id FROM kategori WHERE name='$_GET[kategori]'");
        $kategoriId = mysqli_fetch_array($queryGetKategoriId);
        
        $queryProduk = mysqli_query($con ,"SELECT * FROM produk WHERE kategori_id='$kategoriId[id]'");
    }

// Get produk Default
    else{
        $queryProduk = mysqli_query($con , "SELECT * FROM produk");
    }

    $countData = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko online | Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <?php require "navbar.php"?>

    <!-- BANNER -->
    <div class="container-fluid banner-produk d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Produk</h1>
        </div>
    </div>

    <!-- BODY -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
            <ul class="list-group list-kategori">
                <h3>Kategori</h3>
            <?php while($kategori= mysqli_fetch_array($queryKategori)):?>
                <a class="no-decoration" href="produk.php?kategori=<?=$kategori['name']?>">
                    <li class="list-group-item"><?=$kategori['name']?></li>
                </a>
            <?php endwhile;?>
            </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3">Produk</h3>
                <div class="row">
                    <?php
                        if($countData<1){
                            ?>
                                <h4 class="text-center">Yang anda cari tidak tersedia</h4>
                            <?php
                        }
                    ?>
                    <?php while($produk = mysqli_fetch_array($queryProduk)):?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100" style="">
                            <div class="image-box">
                                <img src="image/<?=$produk['foto']?>" class="card-img-top" alt="...">
                            </div>
                                <div class="card-body">
                                    <h4 class="card-title"><?= $produk['nama']?></h4>
                                    <p class="card-text text-truncate"><?= $produk['detail']?></p>
                                    <p class="card-text text-harga">Rp.<?=$produk['harga']?></p>
                                    <a href="produk_detail.php?nama=<?=$produk['nama']?>" class="btn text-white warna3">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php endwhile;?>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php require "footer.php"?>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>