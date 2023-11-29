<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../')->load();

try {
    $dbDB = new PDO('sqlsrv:Server='.getenv('DB_HOST').';Database='.getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    $dbDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     "Conexão bem-sucedida!";
} catch (PDOException $e) {
     $e->getMessage(); // Output the error message
}
?>
