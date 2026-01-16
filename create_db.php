<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS multi_company_sys");
    echo "Database created successfully.";
} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage());
}
