<?php
session_start();

include '../components/db.php';

// Inisialisasi user_id dari cookie atau buat baru jika belum ada
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30);
    $user_id = $_COOKIE['user_id'];
}

if (isset($_POST['place_order'])) {

    // Membersihkan dan memvalidasi input
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $number = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $address = $_POST['city'].', ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $address_type = filter_input(INPUT_POST, 'address_type', FILTER_SANITIZE_STRING);
    $method = filter_input(INPUT_POST, 'method', FILTER_SANITIZE_STRING);


     // Pastikan bahwa produk_id telah diset
     if (!empty($_GET['get_id'])) {
        $get_product = $conn->prepare("SELECT * FROM `produk` WHERE id = ? LIMIT 1");
        $get_product->bind_param("i", $_GET['get_id']);
        $get_product->execute();

        if ($get_product->num_rows > 0) {
            $order_id = create_unique_id();
            $result = $get_product->get_result();
            $fetch_p = $result->fetch_assoc();

            $insert_order = $conn->prepare("INSERT INTO `orders` (id, user_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_order->bind_param("ssssssssiii", $order_id, $user_id, $name, $number, $email, $address, $address_type, $method, $fetch_p['id'], $fetch_p['price']);

            $insert_order->execute();
            header('location:orders.php');
            $success_msg[] = 'Product Success!';
        } else {
            $warning_msg[] = 'Something went wrong!';
        }
    } else {
        $warning_msg[] = 'No product selected!';

    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../Assets/css/checkout.css">
   <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Viga&display=swap"
      rel="stylesheet"
    />

</head>
<body>
    
<section class="checkout">

   <h1 class="heading">Rincian Pembelian</h1>

   <div class="row">
      <form action="" method="POST">
         <h3>Detail Pembayaran</h3>
         <div class="flex">
            <div class="box">
               <p>Nama Lengkap <span>*</span></p>
               <input type="text" name="name" required maxlength="50" placeholder="Masukan nama lengkap" class="input">
               <p>Nomor Telepon <span>*</span></p>
               <input type="number" name="number" required maxlength="10" placeholder="Masukan nomor telepon" class="input" min="0" max="9999999999">
               <p>Alamat Email <span>*</span></p>
               <input type="email" name="email" required maxlength="50" placeholder="Masukan email" class="input">
               <p>Metode Pembayaran <span>*</span></p>
               <select name="method" class="input" required>
                  <option value="cash on delivery">Cash on Delivery</option>
                  <option value="credit or debit card">Credit or Debit Card</option>
                  <option value="net banking">M-Banking</option>
                  <option value="UPI or wallets">E-Wallet</option>
               </select>
            </div>
            <div class="box">
               <p>Alamat <span>*</span></p>
               <select name="address_type" class="input" required> 
                  <option value="home">Rumah</option>
                  <option value="office">Kantor</option>
               </select>
               <p>Kota <span>*</span></p>
               <input type="text" name="city" required maxlength="50" placeholder="Masukan kota" class="input">
               <p>Alamat Lengkap <span>*</span></p>
               <input type="text" name="country" required maxlength="50" placeholder="Masukan alamat" class="input">
               <p>Kode Pos <span>*</span></p>
               <input type="number" name="pin_code" required maxlength="6" placeholder="123456" class="input" min="0" max="999999">
            </div>
         </div>
         <input type="submit" value="Beli" name="place_order" class="btn">
      </form>

      <?php
      if (isset($_GET['product_id'])) {
          $product_id = $_GET['product_id'];

          // Fetch the product details based on the product_id
          $select_product = $conn->prepare("SELECT * FROM `produk` WHERE id = ? LIMIT 1");
          $select_product->bind_param("i", $product_id);
          $select_product->execute();
          $result_product = $select_product->get_result();

          // Check if the product is found
          if ($result_product->num_rows > 0) {
              $fetch_product = $result_product->fetch_assoc();
              $sub_total = $fetch_product['price']; // Assuming quantity is 1

              $grand_total = $sub_total;

              // Free the result set
              $result_product->free_result();
              $select_product->close();

              ?>
              <div class="flex">
                  <?php
                  if (isset($fetch_product['image']) && !empty($fetch_product['image'])) {
                      $imagePath = '../uploaded_files/' . $fetch_product['image'];
                      ?>
                      <img src="<?= $imagePath; ?>" class="image" alt="<?= $fetch_product['name']; ?>">
                      <?php
                  } else {
                      ?>
                      <p class="empty">Image not available</p>
                      <?php
                  }
                  ?>
                  <div>
                      <h3 class="name"><?= $fetch_product['name']; ?></h3>
                      <p class="price"><i class="fas fa-indian-rupee-sign"></i> <?= $fetch_product['price']; ?> x 1</p>
                  </div>
              </div>

              <?php
          } else {
              echo '<p class="empty">Product not found</p>';
          }
      } else {
          echo '<p class="empty">No product selected</p>';
      }
      ?>

      <!-- Display the grand total -->
      <div class="grand-total"><span>Total Harga :</span><p><i class="fas fa-indian-rupee-sign"></i> <?= $grand_total; ?></p></div>
   </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>
<?php include '../components/alert.php'; ?>

</body>
</html>