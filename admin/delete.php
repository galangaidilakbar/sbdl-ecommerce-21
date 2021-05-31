<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../login/index.php');
    exit;
}

if ($_SESSION['role'] == 'costumer') {
    header('Location: ../login/index.php');
    exit;
}

include '../functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the products ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $products = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$products) {
        exit('Products doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the Products!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: index.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?= admin_template_header('Delete') ?>

<div class="content delete">
    <h2>Delete Products #<?= $products['id'] ?></h2>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php else : ?>
        <p>Are you sure you want to delete products #<?= $products['id'] ?>?</p>
        <div class="yesno">
            <a href="delete.php?id=<?= $products['id'] ?>&confirm=yes" style="background-color: #f44336; color: #FFFFFF;">Yes</a>
            <a href="delete.php?id=<?= $products['id'] ?>&confirm=no">No</a>
        </div>
    <?php endif; ?>
</div>

<?= template_footer() ?>