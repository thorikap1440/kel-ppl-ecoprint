<?php
include '../components/db.php';

if (isset($_GET['product_id'])){
    $id_products = $_GET['product_id'];
    $query = "DELETE FROM `produk` WHERE id = '$id_products';";
    $sql = mysqli_query($conn, $query);

    if($sql){
        echo '<script>alert("Produk berhasil dihapus"); window.location.href = "../pages_admin/view_produk.html";</script>';
        // header("location: ../pages_admin/view_produk.html"); // ubah path agar sesuai dengan struktur folder
        exit();
    } else {
        echo "Terjadi kesalahan dalam menghapus produk";
    }
}
?>

