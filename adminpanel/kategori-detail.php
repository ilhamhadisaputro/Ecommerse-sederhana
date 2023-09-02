<?php
    require "session.php";
    require "../koneksi.php";

    $id = $_GET['p'];
    

    $query = mysqli_query($con, "SELECT * FROM kategori WHERE id='$id' ");
    $data = mysqli_fetch_array($query);

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

</head>
<body>
    <?php require "navbar.php";?>
    

    <div class="container mt-5">
        <h2>Detail Kategori</h2>
            <div class="col-12 col-md-6">
                <form action="" method="POST">
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="<?=@$data['name']?>">
                    <div>
                        <button type="submit" name="editBtn" class="btn btn-primary mt-4"><i class="bi bi-search">Edit</i></button>
                        <button type="submit" name="hapusBtn" class="btn btn-danger mt-4"><i class="bi bi-search">Hapus</i></button>
                    </div>
                </form>
                <?php
                    if(isset($_POST['editBtn'])){
                        $kategori = htmlspecialchars($_POST['kategori']);
                        
                        if($data['name']==$kategori){
                            ?>
                            <meta http-equiv="refresh" content="0"; url-kategori.php />
                            <?php
                            header('location:kategori.php');
                        }else{
                            $query=mysqli_query($con, "SELECT * FROM kategori WHERE name ='$kategori'");
                            $jumlahData= mysqli_num_rows($query);
                            
                            if($jumlahData > 0){
                                ?>
                                <div class="alert alert-warning" role="alert">
                                    Kategori sudah ada!
                                </div>
                                <?php
                            }else{
                                $querySimpan= mysqli_query($con, "UPDATE kategori SET name='$kategori' WHERE id='$id'");
                                if($querySimpan){
                                    ?>
                                    <div class="alert alert-info" role="alert">
                                        input berhasil!
                                    </div>
                                        <meta http-equiv="refresh" content="1"; url-kategori.php />
                                <?php
                            }
                        }
                    }
                }

                if(isset($_POST['hapusBtn'])){
                    $queryCheck = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$id'");
                    $dataCount = mysqli_num_rows($queryCheck);

                    if($dataCount >0){
                        ?>
                        <div class="alert alert-warning" role="alert">
                            Kategori tidak bisa dihapus karena sudah digunakan diproduk!
                        </div>
                    <?php
                        die();
                    }

                    $queryHapus = mysqli_query($con , "DELETE FROM kategori WHERE id='$id'");

                    if($queryHapus){
                        ?>
                        <div class="alert alert-info" role="alert">
                            Kategori berhasil dihapus!
                        </div>
                            <meta http-equiv="refresh" content="1"; url-kategori.php />
                    <?php
                    }else{
                        echo_mysqli_error($con);
                    }              
                } 
                ?>
            </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>