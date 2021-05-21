<?php

// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../phplogin/index.php');
    exit;
}

include '../functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the products id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $desc = isset($_POST['desc']) ? $_POST['desc'] : '';
        $price = isset($_POST['price']) ? $_POST['price'] : '';
        $rrp = isset($_POST['rrp']) ? $_POST['rrp'] : '';
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
        $img = isset($_POST['img']) ? $_POST['img'] : '';
        $dataadded = isset($_POST['data_added']) ? $_POST['data_added'] : date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE `products` SET `name` = ?, `desc` = ?, `price` = ?, `rrp` = ?, `quantity` = ?, `img` = ?, `date_added` = ? WHERE `id` = ?');

        $msg = 'Updated Successfully!';

        try {
            $stmt->execute([$name, $desc, $price, $rrp, $quantity, $img, $dataadded, $_GET['id']]);
        } catch (\Throwable $e) {
            $msg = "Unable to update product, please try again!";
        }
    }
    // Get the products from the products table
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $products = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$products) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?= admin_template_header('Update Product') ?>

<div class="content update">
    <h2>Update Product "<?= $products['name'] ?>"</h2>
    <?php if ($msg == "Updated Successfully!") : ?>
        <div class="alert success">
            <span class="closebtn">&times;</span>
            <p><?= $msg ?></p>
        </div>
    <?php endif; ?>

    <?php if ($msg == "Unable to update product, please try again!") : ?>
        <div class="alert danger">
            <span class="closebtn">&times;</span>
            <p><?= $msg ?></p>
        </div>
    <?php endif; ?>

    <form action="update.php?id=<?= $products['id'] ?>" method="post">
        <label for="id">ID</label>
        <label for="name">Name</label>

        <input type="number" name="id" value="<?= $products['id'] ?>" id="id" title="ID Product cannot be update" readonly>
        <input type="text" name="name" value="<?= $products['name'] ?>" id="name">

        <label for="desc">Description</label>
        <label for="img">Image</label>

        <input type="text" name="desc" value="<?= $products['desc'] ?>" id="desc">
        <input type="file" name="img" value="<?= $products['img'] ?>" id="img">

        <label for="price">Price</label>
        <label for="rrp">RRP</label>

        <input type="number" name="price" value="<?= $products['price'] ?>" id="price">
        <input type="number" name="rrp" value="<?= $products['rrp'] ?>" id="rrp">

        <label for="quantity">Quantity</label>
        <label for="data">Date Added</label>

        <input type="number" name="quantity" value="<?= $products['quantity'] ?>" id="quantity">
        <input type="datetime-local" name="data_added" value="<?= date('Y-m-d\TH:i', strtotime($products['date_added'])) ?>" id="data">
        <input type="submit" value="Update">
    </form>
</div>

<script>
    var close = document.getElementsByClassName("closebtn");
    var i;

    for (i = 0; i < close.length; i++) {
        close[i].onclick = function() {
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function() {
                div.style.display = "none";
            }, 600);
        }
    }
</script>

<?= admin_template_footer() ?>