<?php
include '../components/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    // Pastikan semua data yang diperlukan telah terisi
    if (
        isset($_POST['product_id']) &&
        isset($_POST['category']) &&
        isset($_POST['name']) &&
        isset($_POST['description']) &&
        isset($_POST['detail']) &&
        isset($_POST['price']) &&
        isset($_FILES['image'])
    ) {
        // Tangkap nilai dari form
        $product_id = $_POST['product_id'];
        $category = $_POST['category'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $detail = $_POST['detail'];
        $price = $_POST['price'];
        $image = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];

        // Lakukan sanitasi pada data yang diterima
        $category = mysqli_real_escape_string($conn, $category);
        $name = mysqli_real_escape_string($conn, $name);
        $description = mysqli_real_escape_string($conn, $description);
        $detail = mysqli_real_escape_string($conn, $detail);
        $price = mysqli_real_escape_string($conn, $price);

        $upload_folder = '../uploaded_files/';

        // Pindahkan file gambar yang diunggah ke folder yang ditentukan
        if (move_uploaded_file($image_tmp_name, $upload_folder . $image)) {
            // Query untuk melakukan update data produk
            $query = "UPDATE `produk` SET category='$category', name='$name', description='$description', detail='$detail', price='$price', image='$image' WHERE id='$product_id';";
            $sql = mysqli_query($conn, $query);

            // Periksa apakah query berhasil dijalankan
            if ($sql) {
                // Jika berhasil, redirect ke halaman view_produk.html
                header("Location: ../pages_admin/view_produk.html");
                exit();
            } else {
                echo "Terjadi kesalahan dalam memperbarui data produk: " . mysqli_error($conn);
            }
        } else {
            echo "Gagal mengunggah gambar!";
        }
    } else {
        echo "Semua field harus diisi!";
    }
} else {
    // Ambil data produk berdasarkan product_id yang diberikan
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        $query = "SELECT * FROM `produk` WHERE id = '$product_id';";
        $sql = mysqli_query($conn, $query);
        $result = mysqli_fetch_assoc($sql);

        // Pastikan data ditemukan sebelum menampilkan formulir edit
        if ($result) {
            // Isi variabel dengan data dari database
            $category = $result['category'];
            $name = $result['name'];
            $description = $result['description'];
            $detail = $result['detail'];
            $price = $result['price'];
            $image = $result['image'];
        } else {
            // Redirect ke view_produk.html jika data tidak ditemukan
            header("Location: ../pages_admin/view_produk.html");
            exit();
        }
    } else {
        // Redirect ke view_produk.html jika product_id tidak ditemukan
        header("Location: ../pages_admin/view_produk.html");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Update Produk Ecoprint</title>
        <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
        />
        <link rel="stylesheet" href="../Assets/css/style.css" />
        <link rel="stylesheet" href="../Assets/css/admin.css" />
        <link rel="stylesheet" href="../Assets/css/responsive.css" />
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
        <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Viga&display=swap"
        rel="stylesheet"
        />
        <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css"
        />
</head>
<body>
    <div class="container mt-5">
        <!-- Your Form Section -->
        <form action="../components/update_product.php" method="POST" enctype="multipart/form-data">
            <!-- Form Elements Filled with Retrieved Data -->
            <input type="hidden" name="product_id" value="<?= isset($product_id) ? $product_id : ''; ?>">
        
            <div class="mb-3">
                <label for="category" class="form-label">Kategori Produk</label>
                <select class="form-select custom-select" name="category" aria-label="Default select example">
                    <?php
                    $categories = ['Pilih Kategori', 'Wanita', 'Pria', 'Baju', 'Tas', 'Alas Kaki', 'Lainnya'];
                    foreach ($categories as $cat) {
                        $selected = ($category === $cat) ? 'selected' : '';
                        echo "<option value='$cat' $selected>$cat</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="product" class="form-label">Nama Produk</label>
                <input type="text" name="name" placeholder="Masukan Nama Produk" class="form-control" value="<?= isset($name) ? $name : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi Produk</label>
                <input type="text" name="description" placeholder="Masukan Deskripsi Produk" class="form-control" value="<?= isset($description) ? $description : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">Detail Produk</label>
                <input type="text" name="detail" placeholder="Masukan Detail Produk" class="form-control" value="<?= isset($detail) ? $detail : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Harga Produk</label>
                <input type="number" name="price" placeholder="Masukan Harga Produk" required min="0" max="9999999999" class="form-control" value="<?= isset($price) ? $price : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Foto Produk</label>
                <input class="form-control" type="file" name='image' id="formFile">
            </div>

            <button type="submit" class="btn btn-primary" name="update">Update</button>
        </form>
    </div>
</body>
</html>
