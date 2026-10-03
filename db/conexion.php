<?php
//Esta es otra ofrma de hacerlo pero es mejor la de abajo :)
// $hostname = "";
// $username = "";
// $password = "";
// $database = "";

// mysqli_connect("localhost", "root", "1234", "");

$hostname = "localhost";
$username = "root";
$password = "1234";
$database = "BibliotecasSena";

$conex = mysqli_connect($hostname, $username, $password, $database);