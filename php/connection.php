<?php
$hostname = 'localhost'; //127.0.0.1
$user = 'root';
$password = '';
$database = 'breezequiz';

$connection = mysqli_connect($hostname, $user, $password, $database);
if($connection === false){
    die("Connection Failed " . mysqli_connect_error());
}else{
    //echo 'Connection Established' . "<br>";
}
?>