<!-- SHOPPINGCART
 ****************************************************
 * Developer Team : Galang aidil akbar, Mardha Yuda Kurniawan, Ahmad Sofiyan Alfandi. 
 * Release Date   : 24 May 2021
 * Twitter        : https://twitter.com/galang_aidil, https://twitter.com/alfandi04_ 
 * E-mail         : galangaidil45@gmail.com, yumardha@gmail.com, alfafandi0@gmail.com.
-->

<?php if (isset($_SESSION['loggedin'])) : ?>
  <?= costumer_template_header('Place Order', $_SESSION['name']) ?>
<?php else : ?>
  <?= template_header('Place Order') ?>
<?php endif; ?>

<div class="placeorder content-wrapper">
  <h1>Your Order Has Been Placed</h1>
  <p>Thank you for ordering with us, we'll contact you by email with your order details.</p>
</div>

<?= template_footer() ?>