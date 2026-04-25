<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=vet_system', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully\n";
    $stmt = $pdo->query('SELECT 1');
    echo $stmt->fetchColumn()."\n";
} catch (Exception $e) {
    echo 'Error: '.$e->getMessage()."\n";
}
