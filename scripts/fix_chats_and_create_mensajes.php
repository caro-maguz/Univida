<?php
$dsn = 'mysql:host=127.0.0.1;dbname=univida;charset=utf8';
$user = 'univida_admin';
$pass = '12345';
try{
    $pdo=new PDO($dsn,$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    echo "Connected\n";
    $pdo->exec("ALTER TABLE chats MODIFY usuario_id int(11) NOT NULL;");
    echo "Modified chats.usuario_id to int(11)\n";
    $pdo->exec("ALTER TABLE chats MODIFY psicologo_id int(11) NULL;");
    echo "Modified chats.psicologo_id to int(11)\n";

    // Add foreign keys if not exists
    // Drop if already exists (safe)
    try{
        $pdo->exec("ALTER TABLE chats DROP FOREIGN KEY IF EXISTS fk_chats_usuario;");
    }catch(PDOException $e){ }
    try{
        $pdo->exec("ALTER TABLE chats DROP FOREIGN KEY IF EXISTS fk_chats_psicologo;");
    }catch(PDOException $e){ }

    $pdo->exec("ALTER TABLE chats ADD CONSTRAINT fk_chats_usuario FOREIGN KEY (usuario_id) REFERENCES usuario(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE;");
    echo "Added FK chats.usuario_id -> usuario.id_usuario\n";
    $pdo->exec("ALTER TABLE chats ADD CONSTRAINT fk_chats_psicologo FOREIGN KEY (psicologo_id) REFERENCES psicologo(id_psicologo) ON DELETE SET NULL ON UPDATE CASCADE;");
    echo "Added FK chats.psicologo_id -> psicologo.id_psicologo\n";

    // Create mensajes table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS mensajes (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        chat_id bigint(20) unsigned NOT NULL,
        tipo_remitente enum('usuario','psicologo','sistema') NOT NULL,
        remitente_id bigint(20) unsigned DEFAULT NULL,
        mensaje text NOT NULL,
        leido tinyint(1) NOT NULL DEFAULT 0,
        created_at timestamp NULL DEFAULT NULL,
        updated_at timestamp NULL DEFAULT NULL,
        PRIMARY KEY (id),
        CONSTRAINT fk_mensajes_chat FOREIGN KEY (chat_id) REFERENCES chats(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    echo "Ensured mensajes table exists (created if missing)\n";

}catch(PDOException $e){ echo 'ERROR: '.$e->getMessage().PHP_EOL; }
