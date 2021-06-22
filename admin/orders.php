<!-- SHOPPINGCART
 ****************************************************
 * Developer Team : Galang aidil akbar, Mardha Yuda Kurniawan, Ahmad Sofiyan Alfandi. 
 * Release Date   : 24 May 2021
 * Twitter        : https://twitter.com/galang_aidil, https://twitter.com/alfandi04_ 
 * E-mail         : galangaidil45@gmail.com, yumardha@gmail.com, alfafandi0@gmail.com.
-->

<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
  header('Location: ../login/.');
  exit;
}

if ($_SESSION['role'] == 'costumer') {
  header('Location: ../.');
  exit;
}

include '../functions.php';
// Connect to MySQL database
require_once "../config/database.php";
$conn = new connectDB();
$pdo = $conn->pdo_connect();

$stmt = $pdo->prepare('SELECT * FROM orderan_masuk');
$stmt->execute();

$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= admin_template_header('Orderan masuk') ?>
<div class="content read">
  <h1>Orders</h1>
  <table>
    <thead>
      <tr>
        <td>Product Name</td>
        <td>Pemesan</td>
        <td>Jumlah</td>
        <td>Harga</td>
        <td>Total</td>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($orders)) : ?>
        <tr>
          <td colspan="5" style="text-align:center;">You have no orders</td>
        </tr>
      <?php else : ?>
        <?php foreach ($orders as $order) : ?>
          <tr>
            <td><?= $order['name'] ?></td>
            <td><?= $order['username'] ?></td>
            <td><?= $order['jumlah'] ?></td>
            <td><?= $order['price'] ?></td>
            <td><?= $order['total'] ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?= template_footer() ?>