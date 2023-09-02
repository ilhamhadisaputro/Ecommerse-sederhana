<?php
    session_start();
    require "../koneksi.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<style>
        .main{
            height: 100vh;
        }
        .login-box{
            width:  500px;
            height: 300px;
            padding: 3rem;
            box-sizing: border-box;
            border-radius: 10px;
        }
</style>

<body>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        <div class="login-box shadow">
        <form action="" method="POST">
        <div>
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
        </div>
        <div>
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password">
        </div>
        <div>
            <button class="btn btn-success form-control mt-3" type="submit" name="login">Login</button>
        </div>
    </form>
    </div>
    <div class="mt-3" style="width:500px">

        <?php
    // ketika tombol login di klik maka
        if(isset($_POST['login'])){
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
        
            $query = mysqli_query($con , "SELECT * FROM users WHERE username ='$username'");
            $countdata = mysqli_num_rows($query);
            $data= mysqli_fetch_assoc($query);

             if($countdata==1){
                    if(password_verify($password, $data['password'])) {
                        $_SESSION['username'] = $data['username'];
                        $_SESSION['login'] = TRUE;
                        header('location: index.php');
                        exit;
                    }else{
                        ?>
                    <div class="alert alert-warning text-center" role="alert">
                        Password salah!
                    </div>
              <?php
                    }
             }else{
                ?>
                    <div class="alert alert-warning text-center" role="alert">
                        Akun tidak tersedia!
                    </div>
              <?php
             }
        }
?>
    </div>
</div>
</body>
</html>