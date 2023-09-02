<?php
    require "session.php";
    require "../koneksi.php";

    $query = mysqli_query($con ,"SELECT a.*, b.name AS nama_kategori FROM produk a JOIN kategori b ON a.
    kategori_id=b.id");
    $jumlahProduk = mysqli_num_rows($query);

    $queryKategori= mysqli_query($con, "SELECT * FROM kategori");

    function generateRandomString($lengt = 10) {
        $characters = '123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLenght = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $lengt; $i++){
            $randomString .=$characters[rand(0, $charactersLenght - 1)];
        }
        return $randomString;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
        <!-- bootstrap style -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<body>
<style>
        .none-decoraiton{
        text-decoration: none;
    }
</style>
<body>
<?php require "navbar.php"?>
    <div class="container">
        <div class="container mt-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href="../adminpanel" class="none-decoraiton text-mute"><i class="bi bi-house"></i>Home</li></a>
                    <li class="breadcrumb-item active" aria-current="page"><i class="bi "></i>Produk</li>
                </ol>
            </nav>
        </div>

        <!-- tambah produk -->
    <div class="my-5 col-12 col-md-6">
        <h3>Tambah produk</h3>

        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required>
            </div>
            <label class="mt-3" for="kategori">kategori</label>
            <div>
                <select name="kategori" id="kategori" class="form-control" required>
                    <option value="">-- Pilih Satu --</option>
                    <?php
                        while($data=mysqli_fetch_array($queryKategori)){
                            ?>
                                <option value="<?=$data['id']?>"><?=$data['name']?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
            <div>
                <label class="mt-3" for="harga">Harga</label>
                <input type="number" class="form-control" name="harga" required>
            </div>
            <div>
                <label class="mt-3" for="foto">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <div>
                <label class="mt-3" for="detail">detail</label>
                <textarea name="detail" id="detail" cols="10" rows="5" class="form-control"></textarea>
            </div>
            <div>
                <label for="ketersediaan">ketersediaan stok</label>
                <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                    <option value="tersedia">tersedia</option>
                    <option value="habis">habis</option>
                </select>
            </div>
            <div>
                <button type="submit" name="simpan" class="btn btn-primary mt-3">Simpan</button>
            </div>
        </form>
                        <?php
                        if(isset($_POST['simpan'])){
                            $nama = htmlspecialchars($_POST['nama']);
                            $kategori = htmlspecialchars($_POST['kategori']);
                            $harga = htmlspecialchars($_POST['harga']);
                            $detail = htmlspecialchars($_POST['detail']);
                            $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

                            $target_dir = "../image/";
                            $nama_file      =   basename($_FILES["foto"]["name"]);
                            $target_file    =   $target_dir . $nama_file;
                            $imageFileType  =   strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                            $image_size     =   $_FILES["foto"]["size"];
                            $random_name    =   generateRandomString(20);
                            $new_name       =   $random_name . "." . $imageFileType;

                            if($nama =='' || $kategori ==''|| $harga ==''){
                                ?>
                                <div class="alert alert-info" role="alert">
                                    Data wajib diisi
                                </div>
                            <?php
                            }else{
                                if($nama_file!=''){
                                    if($image_size > 500000){
                                    ?>
                                        <div class="alert alert-warning" role="alert">
                                            File tidak boleh lebih dari 500kb
                                        </div>
                                    <?php
                                    }else{
                                        if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType
                                         != 'gif'){
                                    ?>
                                            <div class="alert alert-warning" role="alert">
                                                File harus bertipe jpg,png,gif!
                                            </div>
                                    <?php
                                         }else{
                                            (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir .$new_name));
                                         }
                                    }
                                }
                                     // query insert
                                     $queryTambah = mysqli_query($con, "INSERT INTO produk (kategori_id,nama,harga,foto,detail,ketersediaan_stok)
                                                                VALUES('$kategori','$nama','$harga','$new_name','$detail','$ketersediaan_stok')");

                                            if($queryTambah){
                                                ?>
                                                    <meta http-equiv="refresh" content="0"; url-produk.php />
                                                    <div class="alert alert-warning" role="alert">
                                                        produk berhasil disimpan
                                                    </div>
                                                <?php
                                            }else{
                                                echo_mysqli_error($con);
                                            }
                            }
                        }
                        ?>

    </div>

    <div class="mt-3">
        <h2>List Produk</h2>

        <div class="table table-responsive">
            <table class="table mb-5">
                <thead>
                    <tr>
                        <th>No,</th>
                        <th>Nama</th>
                        <th>kategori</th>
                        <th>Harga</th>
                        <th>Ketersediaan stok</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($jumlahProduk==0){
                            ?>
                            <tr>
                                <td colspan=6 class="text-center">Data Produk tidak tersedia</td>
                            </tr>
                            <?php
                        }else{
                            $jumlah=1;
                            while($data=mysqli_fetch_array($query)){
                                ?>
                                    <tr>
                                        <td><?=$jumlah++?></td>
                                        <td><?=$data['nama']?></td>
                                        <td><?=$data['nama_kategori']?></td>
                                        <td><?=$data['harga']?></td>
                                        <td><?=$data['ketersediaan_stok']?></td>
                                        <td><a href="produk_detail.php?p=<?=$data['id']?>" class="btn btn-info"><i class="bi bi-search"></i></a></td>
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