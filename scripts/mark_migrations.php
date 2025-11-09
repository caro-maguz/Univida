<?php
$dsn='mysql:host=127.0.0.1;dbname=univida;charset=utf8';
$user='univida_admin';
$pass='12345';
try{
 $pdo=new PDO($dsn,$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
 $migrations=['2025_11_09_003651_create_chats_table','2025_11_09_003736_create_mensajes_table'];
 $stmt=$pdo->query('SELECT MAX(batch) as mb FROM migrations');
 $mb=$stmt->fetch(PDO::FETCH_ASSOC)['mb'];
 $next = $mb ? $mb+1 : 1;
 foreach($migrations as $m){
   $pdo->prepare('INSERT INTO migrations (migration,batch) VALUES (?,?)')->execute([$m,$next]);
   echo "Inserted migration $m with batch $next\n";
 }
}catch(PDOException $e){ echo 'ERROR: '.$e->getMessage().PHP_EOL; }
