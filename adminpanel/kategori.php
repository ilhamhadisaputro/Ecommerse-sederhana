<?php
    require "session.php";
    require "../koneksi.php";
    
    $queryKategori= mysqli_query($con , "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>
    <!-- bootstrap style -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<style>
        .none-decoraiton{
        text-decoration: none;
    }
</style>
<body>
    <?php require "navbar.php"?>
    <div class="container mt-5">
    <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><a href="../adminpanel" class="none-decoraiton text-mute"><i class="bi bi-house"></i>Home</li></a>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi "></i>Kategori</li>
            </ol>
        </nav>

        <div class="my-5 col-12 col-md-6">
            <h3>Tambah kategori</h3>
            <form action="" method="post">
                <div>
                    <label for="kategori">kategori</label>
                    <input type="text" id="kategori" name="kategori" placeholder="input nama kategori"
                    class="form-control">
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submmit" name="simpan_kategori">simpan</button>
                </div>
            </form>
            <?php
            if(isset($_POST['simpan_kategori'])){
                $kategori= htmlspecialchars($_POST['kategori']);

                $queryExist = mysqli_query($con, "SELECT name FROM kategori where name = '$kategori'");
                $jumlahKategoriBaru = mysqli_num_rows($queryExist);

                if($jumlahKategoriBaru > 0){
                    ?>
                    <div class="alert alert-info" role="alert">
                        sudah ada!
                    </div>
                    <?php
                }else{
                    $querySimpan= mysqli_query($con, "INSERT INTO kategori (name) values ('$kategori')");
                    if($querySimpan){
                        ?>
                        <div class="alert alert-info" role="alert">
                            input berhasil!
                        </div>
                    <!-- CARA REFRESH OTOMATIS SETELAH INPUT -->
                    <!-- Note: Karna PHP tidak mendukung refresh otomatis setelah input -->
                    <meta http-equiv="refresh" content="1"; url-kategori.php />
                    <?php
                    }else{
                        echo_mysqli_error($con);
                    }
                    
                    
                    
                }
            }
            ?>
        </div>

        <div class="mt-3">
            <h2>List Kategori</h2>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No,</th>
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($jumlahKategori==0){
                                ?>
                                    <tr>
                                        <td class="text-center">Data kategori tidak tersedia</td>
                                    </tr>
                                <?php
                            }else{
                                $jumlah=1;
                                while($data=mysqli_fetch_array($queryKategori)){
                                ?>
                                    <tr>
                                        <td><?= $jumlah++;?></td>
                                        <td><?= $data['name'];?></td>
                                        <td><a href="kategori-detail.php?p=<?=$data['id']?>" class="btn btn-info"><i class="bi bi-search"></i></a></td>
                                    </tr>
                                <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>