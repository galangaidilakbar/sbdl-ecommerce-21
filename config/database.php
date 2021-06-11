<?php
class connectDB
{
  private $dbHost = "localhost";
  private $dbUser = "root";
  private $dbPassword = "";
  private $dbName = "shoppingcart";

  function pdo_connect()
  {
    try {
      $pdo = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPassword);
      return $pdo;
    } catch (PDOException $th) {
      echo "Terjadi masalah : " . $th->getMessage() . "<br>";
      echo "<h4>Detail Masalah</h4>";
      echo "<ol>";
      echo "<li>Kode Masalah : " . $th->getCode() . "</li>";
      echo "<li>Lokasi File: " . $th->getFile() . "</li>";
      echo "<li>Pada baris ke : " . $th->getLine() . "</li>";
      echo "</ol>";
    }
  }
}
