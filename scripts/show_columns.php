<?php
$dsn = 'mysql:host=127.0.0.1;dbname=univida;charset=utf8';
$user = 'univida_admin';
$pass = '12345';
$tables=['usuario','psicologo','chats','chat','mensaje_chat'];
try{
 $pdo=new PDO($dsn,$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
 foreach($tables as $t){
   echo "-- COLUMNS $t --\n";
   try{
     $stmt=$pdo->query("SHOW COLUMNS FROM `$t`");
     $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
     foreach($rows as $r){ echo $r['Field']." | ".$r['Type']." | ".$r['Null']." | ".$r['Key']." | ".$r['Extra'].PHP_EOL; }
   }catch(PDOException $e){ echo "Table $t: " . $e->getMessage() . PHP_EOL; }
   echo PHP_EOL;
 }
}catch(PDOException $e){ echo 'ERROR: '.$e->getMessage().PHP_EOL; }
