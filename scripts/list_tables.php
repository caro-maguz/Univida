<?php

$dsn = 'mysql:host=127.0.0.1;dbname=univida;charset=utf8';
$user = 'univida_admin';
$pass = '12345';

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->query('SHOW TABLES');
    $rows = $stmt->fetchAll(PDO::FETCH_NUM);
    foreach ($rows as $r) {
        echo $r[0] . PHP_EOL;
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
