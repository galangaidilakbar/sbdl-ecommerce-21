<?php
class product
{
  function recently_added()
  {
    require_once "config/database.php";
    $conn = new connectDB();

    $pdo = $conn->pdo_connect();

    $query = "SELECT * FROM `recently_added`";

    $stmt = $pdo->prepare($query);

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $conn = null;
    $stmt = null;

    return $result;
  }

  function show_product($id)
  {
    require_once "config/database.php";
    $conn = new connectDB();

    $pdo = $conn->pdo_connect();

    $stmt = $pdo->prepare('CALL tampilkan_produk(?)');

    $stmt->execute([$id]);

    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    $conn = null;
    $stmt = null;

    return $product;
  }
}
