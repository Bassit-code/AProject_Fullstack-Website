<?php
$db_host = 'localhost';
$db_name = 'u_220115890_db';
$username = 'u-220115890';
$password = 'NDpMivCuVLiv5SO';

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $username, $password);
    echo "You have successfully connected to the database<br>";
} catch (PDOException $ex) {
    echo "Failed to connect to database.<br>";
    echo ($ex->getMessage());
    exit;
}

?>