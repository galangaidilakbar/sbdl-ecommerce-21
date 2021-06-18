<!-- SHOPPINGCART
 ****************************************************
 * Developer Team : Galang aidil akbar, Mardha Yuda Kurniawan, Ahmad Sofiyan Alfandi. 
 * Release Date   : 24 May 2021
 * Twitter        : https://twitter.com/galang_aidil, https://twitter.com/alfandi04_ 
 * E-mail         : galangaidil45@gmail.com, yumardha@gmail.com, alfafandi0@gmail.com.
-->

<?php

session_start();

include 'functions.php';

/*
EN : Connecting to the database using PHP Object Oriented Programming 
ID : Menghubungkan ke database menggunakan PHP Pemrograman Berorientasi Objek
*/
require_once "config/database.php";
$conn = new connectDB();
$pdo = $conn->pdo_connect();

/* 
EN : Page is set to home.php by default, so when the visitor visits website, home.php will be the page they see.
ID : Halaman diatur ke home.php secara default, jadi ketika pengunjung mengunjungi situs, home.php akan menjadi halaman yang mereka lihat.
*/
$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'home';

/*
EN : Include and show the requested page
ID : Sertakan dan tampilkan halaman yang diminta
*/
include $page . '.php';
