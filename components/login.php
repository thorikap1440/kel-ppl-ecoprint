<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
    <link rel="stylesheet" href="../Assets/css/masuk.css" />
</head>
<body id="bg-login" >
    <div class="box-login">
        <h2>Login</h2>
        <form action="" method="POST">
            <label for="user">Alamat Email</label>
            <input type="email" name="user" placeholder="Email" class="input-control">
            <label for="pass">Password</label>
            <input type="password" name="pass" placeholder="Password" class="input-control">
            <label for="role">Login Sebagai:</label>
            <select name="role" id="role" class="input-control">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <input type="submit" name="submit" value="Login" class="btn">
        </form>
        <?php
            if(isset($_POST['submit'])){
                session_start();
                include 'db.php';

                $user = $_POST['user'];
                $pass = $_POST['pass'];
                $role = $_POST['role'];

                $cek = mysqli_query($conn, "SELECT * FROM user WHERE email = '".$user."' AND password = '".MD5($pass)."'");
                if(mysqli_num_rows($cek)>0){
                    $d = mysqli_fetch_object($cek);
                    $_SESSION['status_login'] =  true;
                    $_SESSION['a_global'] = $d;
                    $_SESSION['a_id'] = $d->id; 
                    if ($role == 'admin') {
                        echo '<script>window.location="../pages_admin/add_produk.html"</script>'; // Redirect ke halaman dashboard admin jika login sebagai admin
                    } else {
                        echo '<script>window.location="../index.html"</script>'; // Redirect ke halaman dashboard user jika login sebagai user
                    }
                    echo '<script>window.location="../index.html"</script>';
                }else{
                    echo '<script>alert("Nama atau Password Kamu Salah")</script>';
                }
            }
        ?>
    </div>
</body>
</html>