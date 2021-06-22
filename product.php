<!-- SHOPPINGCART
 ****************************************************
 * Developer Team : Galang aidil akbar, Mardha Yuda Kurniawan, Ahmad Sofiyan Alfandi. 
 * Release Date   : 24 May 2021
 * Twitter        : https://twitter.com/galang_aidil, https://twitter.com/alfandi04_ 
 * E-mail         : galangaidil45@gmail.com, yumardha@gmail.com, alfafandi0@gmail.com.
-->

<?php
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {

  // if id is specified in the URL
  // reqiure with the PHP-OOP class to show the product
  require_once "manage-product.php";
  $data = new product();

  // Fetch the product from the PHP-OOP class with function show_product(param)
  // pass the $_GET['id'] into parameter
  $product = $data->show_product($_GET['id']);

  // Check if the product exists
  if (!$product) {

    // Simple error to display if the id for the product doesn't exists
    exit('Product does not exist!');
  }
} else {

  // Simple error to display if the id wasn't specified
  exit('Product does not exist!');
}
?>

<!-- 
EN : to find out if the customer has logged in or not, we have to check session 'loggedin'. if it isset and has a value of true, then use costumer_template_header(?,?).if not, use template_header().

ID : juntuk mengetahui pelanggan sudah login atau belum, kita bisa mengeceknya menggunakan session 'loginin'. jika sudah diatur dan memiliki nilai true, maka gunakan costumer_template_header(?,?). kalau belum, gunakan template_header()
-->
<?php if (isset($_SESSION['loggedin'])) : ?>
  <?= costumer_template_header($product['name'], $_SESSION['name']) ?>
<?php else : ?>
  <?= template_header($product['name']) ?>
<?php endif; ?>

<div class="product content-wrapper">
  <img src="assets/products/<?= $product['img'] ?>" width="500" height="500" alt="<?= $product['name'] ?>">
  <div>
    <h1 class="name"><?= $product['name'] ?></h1>
    <span class="price">
      &dollar;<?= $product['price'] ?>
      <?php if ($product['rrp'] > 0) : ?>
        <span class="rrp">&dollar;<?= $product['rrp'] ?></span>
      <?php endif; ?>
    </span>
    <form action="index.php?page=cart" method="post">
      <input type="number" name="quantity" value="1" min="1" max="<?= $product['quantity'] ?>" placeholder="Quantity" required>
      <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
      <input type="submit" value="Add To Cart">
    </form>
    <div class="description">
      <?= $product['desc'] ?>
    </div>
  </div>
</div>

<?= template_footer() ?>