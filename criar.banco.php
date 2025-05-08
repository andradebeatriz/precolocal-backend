<?php
// Definir o caminho do banco de dados SQLite
$dbFile = 'usuarios.db'; // O banco de dados será criado aqui

// Criar conexão com o banco de dados
try {
    $db = new PDO("sqlite:" . $dbFile);
    echo "Banco de dados criado com sucesso!<br>";

    // Definir o modo de erro do PDO para exceções
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criar a tabela 'usuarios' se ela não existir
    $sql = "CREATE TABLE IF NOT EXISTS usuarios (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL,
                token TEXT
            )";

            
    $db->exec($sql);
    echo "Tabela 'usuarios' criada com sucesso!<br>";

} catch (PDOException $e) {
    echo "Erro ao criar banco de dados: " . $e->getMessage();
}

// Fechar a conexão
$db = null;
?>
