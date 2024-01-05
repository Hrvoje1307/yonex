<?php
session_start();

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'yonex';

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Problem sa serverom, problem cemo otkloniti uskoro...");
}

?>