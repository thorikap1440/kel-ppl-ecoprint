<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
    <link rel="stylesheet" href="../Assets/css/login.css" />
</head>
<body id="bg-login" >
    <div class="box-login">
        <h2>Daftar</h2>
        <?php
          if (isset($_POST["submit"])) {
            $fullName = $_POST["fullname"];
            $email = $_POST["email"];
            $pass = $_POST["password"];

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $errors = array();
            if (empty($fullName) OR empty($email) OR empty($password)) {
              array_push($errors,"All fields are required");
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              array_push($errors,"Email is not valid");
            }
            if(strlen($password)<8) {
              array_push($errors,"Password must be at least 8 character long");
            }
            if (count($errors) > 0) {
              foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
          }
        }
        ?>
        <form action="register.php" method="POST">
            <input type="text" name="fullName" placeholder="Nama Lengkap" class="input-control">
            <input type="text" name="email" placeholder="Alamat Email" class="input-control">
            <input type="password" name="password" placeholder="Password" class="input-control">
            <input type="submit" name="submit" value="Daftar" class="btn">
        </form>
        <?php
            if(isset($_POST['submit'])){
                session_start();
                include 'db.php';

                $user = $_POST['user'];
                $pass = $_POST['pass'];

                $cek = mysqli_query($conn, "SELECT * FROM admin WHERE nama = '".$user."' AND password = '".MD5($pass)."'");
                if(mysqli_num_rows($cek)>0){
                    $d = mysqli_fetch_object($cek);
                    $_SESSION['status_login'] =  true;
                    $_SESSION['a_global'] = $d;
                    $_SESSION['a_id'] = $d->id; 
                    echo '<script>window.location="../index.html"</script>';
                }else{
                    echo '<script>alert("Nama atau Password Kamu Salah")</script>';
                }
            }
        ?>
    </div>
</body>
</html>