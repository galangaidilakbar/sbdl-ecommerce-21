<!-- SHOPPINGCART
 ****************************************************
 * Developer Team : Galang aidil akbar, Mardha Yuda Kurniawan, Ahmad Sofiyan Alfandi. 
 * Release Date   : 24 May 2021
 * Twitter        : https://twitter.com/galang_aidil, https://twitter.com/alfandi04_ 
 * E-mail         : galangaidil45@gmail.com, yumardha@gmail.com, alfafandi0@gmail.com.
-->

<?php
class product
{
  function recently_added()
  {
    // create connection to database
    require_once "config/database.php";
    $conn = new connectDB();
    $pdo = $conn->pdo_connect();

    //Prepare the query
    $query = "SELECT * FROM `recently_added`";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Get the products
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Close Connection
    $conn = null;
    $stmt = null;

    return $result;
  }

  function show_product($id)
  {
    // create connection to database
    require_once "config/database.php";
    $conn = new connectDB();
    $pdo = $conn->pdo_connect();

    // Prepare the query
    // The query is self is Stored Procedure
    $stmt = $pdo->prepare('CALL tampilkan_produk(?)');
    $stmt->execute([$id]);

    // Get the product
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close Connection
    $conn = null;
    $stmt = null;

    return $product;
  }

  function check_product($id)
  {
    // create connection to database
    require_once "config/database.php";
    $conn = new connectDB();
    $pdo = $conn->pdo_connect();

    // Prepare the query
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$id]);

    // Get the product
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close Connection
    $conn = null;
    $stmt = null;

    return $product;
  }
}
