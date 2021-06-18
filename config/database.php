<!-- Membuat koneksi ke database menggunakan PHP OOP -->

<?php
class connectDB
{
  // Sesuaikan dengan Detail MySQL mu ya!
  private $dbHost = "localhost";
  private $dbUser = "root";
  private $dbPassword = "";
  private $dbName = "shoppingcart";

  function pdo_connect()
  {
    // Dengan PDO, kita bisa menggunakan try and catch
  
    try {
      return new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPassword);
    } catch (PDOException $e) {

      // Jika ada kesalahan dengan koneksi, hentikan skrip dan tampilkan kesalahan.
      echo "Terjadi masalah : <strong>" . $e->getMessage() . "</strong> <br>";
      echo "<h3>Detail Masalah</h3>";
      echo "<ol>";
        echo "<li>Kode Masalah : " . $e->getCode() . "</li>";
        echo "<li>Lokasi File: " . $e->getFile() . "</li>";
        echo "<li>Pada baris ke : " . $e->getLine() . "</li>";
      echo "</ol>";
      exit;
    }
  }
}
