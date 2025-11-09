<?php
$dsn = 'mysql:host=127.0.0.1;dbname=univida;charset=utf8';
$user = 'univida_admin';
$pass = '12345';
try{
    $pdo=new PDO($dsn,$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $stmt=$pdo->query('SELECT migration,batch FROM migrations ORDER BY batch,migration');
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($rows as $r){ echo $r['migration'].' | batch:'.$r['batch'].PHP_EOL; }
}catch(PDOException $e){ echo 'ERROR: '.$e->getMessage().PHP_EOL; }
