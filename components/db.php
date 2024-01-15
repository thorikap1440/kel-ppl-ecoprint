<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$dbname = 'ecoprint_db';

$conn = mysqli_connect($hostname, $username, $password, $dbname) or die('Gagal terhubung ke database');

if (!function_exists('create_unique_id')) {
    function create_unique_id()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 20; $i++) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
?>
