<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "online_shop";

$dns = "mysql:host=$host;dbname=$database";

try {
    //$conn = new PDO("mysql:host=$host;dbname=$database" , $username,$password);
    $conn = new PDO($dns, $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "PDO Connected successfully";

} catch (PDOException $e) {
    echo "PDO Connected successfully " . $e->getMessage();
}

?>