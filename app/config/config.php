<?php
session_start();
require "./vendor/autoload.php";
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../classes');
$dotenv->load();

$hostname = $_ENV["DB_HOST"];
$username = $_ENV["DB_USERNAME"];
$password = $_ENV["DB_PASSWORD"];
$database = $_ENV["DB_DATABASE"];

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Problem sa serverom, problem cemo otkloniti uskoro...");
}

?>