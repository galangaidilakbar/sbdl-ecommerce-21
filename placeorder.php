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