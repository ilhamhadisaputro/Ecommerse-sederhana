<?php
    require "session.php";
    require "../koneksi.php";

    $id = $_GET['p'];
    

    $query = mysqli_query($con, "SELECT a.*, b.name AS nama_kategori FROM produk a JOIN kategori b ON a.
    kategori_id=b.id WHERE a.id='$id' ");
    $data = mysqli_fetch_array($query);

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");
    

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
    <title>produk detail</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

</head>
<body>
<?php require "navbar.php";?>
<div class="container mt-5">
    <h2>Detail Produk</h2>

    <div class="col-12 col-md-6">
        <form action="" method="post" enctype="multipart/form-data" class="mb-5">
            <div>
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?=@$data['nama']?>" autocomplate=off required>
            </div>
            <label for="kategori" class="mt-3">kategori</label>
            <select name="kategori" id="kategori" class="form-control" required>
                    <option value="<?=@$data['kategori_id'];?>"><?=@$data['nama_kategori']?></option>
                    <?php
                        while($dataKategori=mysqli_fetch_array($queryKategori)){
                            ?>
                                <option value="<?=@$dataKategori['id']?>"><?=@$dataKategori['name']?></option>
                            <?php
                        }
                    ?>
                </select>
            <div>
                <label class="mt-3" for="harga">harga</label>
                <input type="number" name="harga" id="harga" class="form-control" value="<?=@$data['harga']?>" required>
            </div>
            <div>
                <label for="currentFoto" class="mt-3">Foto produk sekarang</label>
                <img src="../image/<?=$data['foto']?>" alt="" width="300px">
            </div>
            <div>
                <label for="foto" class="mt-4">foto</label>
                <input type="file" name="foto" id="foto" class="form-control" value="<?=@$data['foto']?>">
            </div>
            <div>
                <label for="detail" class="mt-4">detail</label>
                <textarea name="detail" id="detail" cols="30" rows="10" class="form-control">
                    <?=@$data['detail']?>
                </textarea>
            </div>
            <div>
                <label for="ketersediaan">ketersediaan stok</label>
                <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                    <option value="<?=@$data['ketersediaan_stok']?>"></option>
                    <?php
                        if($data['ketersediaan_stok']=='tersedia'){
                            ?>
                            <option value="habis">habis</option>
                            <?php
                        }else{
                            ?>
                            <option value="tersedia">tersedia</option>
                            <?php
                        }
                    ?>
                </select>
            </div class="d-flex justify-between">
            <button type="submit" name="simpan" class="btn btn-primary mt-3">Simpan</button>
            <button type="submit" name="hapus" class="btn btn-danger mt-3">Hapus</button>
        </form>
        <?php
        if(isset($_POST['simpan'])){
            $nama = htmlspecialchars($_POST['nama']);
            $kategori = htmlspecialchars($_POST['kategori']);
            $harga = htmlspecialchars($_POST['harga']);
            $detail = htmlspecialchars($_POST['detail']);
            $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

            $target_dir     =   "../image/";
            $nama_file      =   basename($_FILES["foto"]["name"]);
            $target_file    =   $target_dir . $nama_file;
            $imageFileType  =   strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $image_size     =   $_FILES["foto"]["size"];
            $name_random    =   generateRandomString(25);
            $new_name       =   $name_random . "." . $imageFileType;

            
            if($nama =='' || $kategori ==''|| $harga ==''){
                ?>
                    <div class="alert alert-info" role="alert">
                                    Data wajib diisi
                    </div>
                <?php
            }else{
                $queryUpdate = mysqli_query($con , "UPDATE produk SET kategori_id='$kategori', 
                nama='$nama',harga='$harga', detail='$detail', ketersediaan_stok='$ketersediaan_stok' WHERE id='$id'");

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
                    }
                    else{
                        (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir .$new_name));

                        $queryUpdate = mysqli_query($con , "UPDATE produk SET foto='$new_name' WHERE id='$id'");
                        if($queryUpdate){
                            ?>
                                <meta http-equiv="refresh" content="0"; url-produk.php />
                                <div class="alert alert-warning" role="alert">
                                    produk berhasil disimpan
                                </div>
                            <?php
                        }else{
                            echo mysqli_error($con);
                        }
                    }
                }
            }
            }
            
        }

        if(isset($_POST['hapus'])){
            $queryHapus = mysqli_query($con , "DELETE FROM produk where id='$id'");
            ?>
            <meta http-equiv="refresh" content="0"; url="produk.php" />
            <div class="alert alert-warning" role="alert">
                produk berhasil dihapus
            </div>
        <?php
        }
        ?>
    </div>
</div>
    


<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>