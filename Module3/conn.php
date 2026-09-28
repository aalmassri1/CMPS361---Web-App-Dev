<?php

$host = "localhost";
$port = "5432";
$dbname = "teams";
$user = "postgres";
$password = "apple";

$dsn = "pgsql:host=$host;port=$port;dbname=dbname";
try {
    $pdo = new PDO($dsn,$user,$password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Successfully connected to the database!";

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>