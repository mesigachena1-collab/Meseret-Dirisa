<?php
// Database connection for World Culture Show
$host = 'localhost';
$db   = 'WorldCultureShow';  
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,      // Throw exceptions on errors
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch as associative array
        PDO::ATTR_EMULATE_PREPARES => false,              // Disable emulated prepared statements
    ]);
} catch (PDOException $e) {
    exit('Database connection failed: ' . $e->getMessage());
}
?>
