<!-- SHOPPINGCART
 ****************************************************
 * Developer Team : Galang aidil akbar, Mardha Yuda Kurniawan, Ahmad Sofiyan Alfandi. 
 * Release Date   : 24 May 2021
 * Twitter        : https://twitter.com/galang_aidil, https://twitter.com/alfandi04_ 
 * E-mail         : galangaidil45@gmail.com, yumardha@gmail.com, alfafandi0@gmail.com.
-->

<?php

/* 
EN : Include manage-product.php to create products class
ID : Sertakan manage-product.php untuk membuat kelas products
*/
require_once "manage-product.php";
$products = new product();

/* 
EN : Get the 4 most recently added products using function recently_added()
ID : Dapatkan 4 produk yang paling baru ditambahkan menggunakan fungsi recently_added()
*/
$recently_added_products = $products->recently_added();

?>

<!-- 
EN : to find out if the customer has logged in or not, we have to check session 'loggedin'. if it isset and has a value of true, then use costumer_template_header(?,?).if not, use template_header().

ID : juntuk mengetahui pelanggan sudah login atau belum, kita bisa mengeceknya menggunakan session 'loginin'. jika sudah diatur dan memiliki nilai true, maka gunakan costumer_template_header(?,?). kalau belum, gunakan template_header()
-->
<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE) : ?>
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

        <img src="assets/products/<?= $product['img'] ?>" width="200" height="200" alt="<?= $product['name'] ?>">

        <span class="name"><?= $product['name'] ?></span>

        <span class="price"> &dollar;<?= $product['price'] ?>

          <?php if ($product['rrp'] > 0) : ?>
            <span class="rrp">&dollar;<?= $product['rrp'] ?></span>
          <?php endif; ?>

        </span>

      </a>

    <?php endforeach; ?>
  </div>
</div>

<?= template_footer() ?>