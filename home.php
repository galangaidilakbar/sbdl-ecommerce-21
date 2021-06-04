<?php
// Get the 4 most recently added products using view recently_added
$stmt = $pdo->prepare('SELECT * FROM `recently_added`');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (isset($_SESSION['loggedin'])) : ?>
  <?= costumer_template_header('Situs Jual Beli Gagdet No. 1 Di Indonesia', $_SESSION['name']) ?>
<?php else : ?>
  <?= template_header('Situs Jual Beli Gagdet No. 1 Di Indonesia') ?>
<?php endif; ?>

<div class="featured">
  <h2>Gadgets</h2>
  <p>Essential gadgets for everyday use</p>
</div>
<div class="recentlyadded content-wrapper">
  <h2>Recently Added Products</h2>
  <div class="products">
    <?php foreach ($recently_added_products as $product) : ?>
      <a href="index.php?page=product&id=<?= $product['id'] ?>" class="product">
        <img src="imgs/<?= $product['img'] ?>" width="200" height="200" alt="<?= $product['name'] ?>">
        <span class="name"><?= $product['name'] ?></span>
        <span class="price">
          &dollar;<?= $product['price'] ?>
          <?php if ($product['rrp'] > 0) : ?>
            <span class="rrp">&dollar;<?= $product['rrp'] ?></span>
          <?php endif; ?>
        </span>
      </a>
    <?php endforeach; ?>
  </div>
</div>

<?= template_footer() ?>