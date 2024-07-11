<?php
session_start();
require 'Class/Products.php';

// Display PHP errors
error_reporting(0);
ini_set('display_errors', 'on');

// Check user role and include appropriate header
if ($_SESSION['role'] == 'admin') {
    require('layout/template/headerAdmin.php');
} else {
    require('layout/template/header.php');
}


// Fetch products
$product = new Products();
$products = $product->read();
?>

<div class="container-home">
  <h2>Products Available for Purchase</h2>

  <div class="row" style="display: flex; flex-wrap: wrap; justify-content: space-around;">

  <?php if (!empty($products)) : ?>
    <?php foreach ($products as $product) : ?>
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="/layout/admin/products/image/<?= htmlspecialchars($product['image']); ?>" class="card-img-top" style="width:10%;" alt="<?= htmlspecialchars($product['name']); ?>">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($product['name']); ?></h5>
            <p class="card-text"><?= htmlspecialchars($product['description']); ?></p>
            <p class="card-price">Price: $<?= number_format($product['price'], 2); ?></p>
            <a href="#" class="btn">Buy Now</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else : ?>
    <p class="no-products">No products available for purchase.</p>
  <?php endif; ?>

  </div>
</div>

<?php
// Include footer template
require 'layout/template/footer.php';
?>
