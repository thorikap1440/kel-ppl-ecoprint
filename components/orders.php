<?php
include '../components/db.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30);
    $user_id = $_COOKIE['user_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pesanan Saya</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
<section class="orders">
   <h1 class="heading">Pesanan Saya</h1>

   <div class="box-container">

   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY date DESC");
      $select_orders->bind_param("s", $user_id); // Bind the parameter
      $select_orders->execute();
      $select_orders->store_result();
      
      if ($select_orders->num_rows > 0) {
         $select_orders->bind_result($order_id, $order_user_id, $order_name, $order_number, $order_email, $order_address, $order_address_type, $order_method, $order_product_id, $order_price, $order_qty, $order_date, $order_status);

         while ($select_orders->fetch()) {
            // Execute the second prepared statement to fetch product details
            $select_product = $conn->prepare("SELECT id, name, image FROM `produk` WHERE id = ?");
            $select_product->bind_param("i", $order_product_id);
            $select_product->execute();
            $select_product->store_result();

            if ($select_product->num_rows > 0) {
               $select_product->bind_result($product_id, $product_name, $product_image);

               while ($select_product->fetch()) {
                  // Your existing code
                  ?>
                  <div class="box" <?php if ($order_status == 'canceled') {echo 'style="border:.2rem solid red";';}; ?>>
                      <a href="view_order.php?get_id=<?= $order_id; ?>">
                          <p class="date"><i class="fa fa-calendar"></i><span><?= $order_date; ?></span></p>
                          <img src="uploaded_files/<?= $product_image; ?>" class="image" alt="">
                          <h3 class="name"><?= $product_name; ?></h3>
                          <p class="price"><i class="fas fa-indian-rupee-sign"></i> <?= $order_price; ?> x <?= $order_qty; ?></p>
                          <p class="status" style="color:<?php if ($order_status == 'delivered') {echo 'green';} elseif ($order_status == 'canceled') {echo 'red';} else {echo 'orange';}; ?>"><?= $order_status; ?></p>
                      </a>
                  </div>
                  <?php
               }
            } else {
               echo '<p class="empty">No product found for order ID: ' . $order_id . '</p>';
            }
         }
      } else {
         echo '<p class="empty">no orders found!</p>';
      }
   ?>
   </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/script.js"></script>
<?php include '../components/alert.php'; ?>
</body>
</html>
