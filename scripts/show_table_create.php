<?php

$dsn = 'mysql:host=127.0.0.1;dbname=univida;charset=utf8';
$user = 'univida_admin';
$pass = '12345';

$tables = ['usuario','chats','chat','mensajes','mensaje_chat'];

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    foreach ($tables as $t) {
        echo "-- SHOW CREATE TABLE $t --\n";
        try {
            $stmt = $pdo->query("SHOW CREATE TABLE `$t`");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $row['Create Table'] . "\n\n";
        } catch (PDOException $e) {
            echo "Table $t: ERROR: " . $e->getMessage() . "\n\n";
        }
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
