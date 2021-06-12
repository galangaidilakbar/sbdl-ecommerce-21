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

<!-- check if the costumer is already login -->
<?php if (isset($_SESSION['loggedin'])) : ?>

  <!-- Load header with costumer name and logout button -->
  <?= costumer_template_header($product['name'], $_SESSION['name']) ?>

<?php else : ?>

  <!-- Use default header if costumer wasn't login -->
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