<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Lê os dados JSON do corpo da requisição
$data = json_decode(file_get_contents("php://input"));

// Verifica se os dados estão presentes
if (
    !isset($data->nome) || empty($data->nome) ||
    !isset($data->email) || empty($data->email) ||
    !isset($data->password) || empty($data->password)
) {
    http_response_code(400);  // Código de erro de requisição inválida
    echo json_encode(["status" => "error", "message" => "Dados inválidos."]);
    exit;
}

try {
    // Conecta ao banco de dados SQLite
    $db = new PDO("sqlite:" . __DIR__ . "/../../../usuarios.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbPath = realpath(__DIR__ . "/../../../usuarios.db");
    if (!file_exists($dbPath)) {
        echo json_encode(["success" => false, "message" => "Banco de dados não encontrado."]);
        exit;
    }

    // Verifica se o e-mail já existe
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $data->email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo json_encode(["status" => "error", "message" => "E-mail já cadastrado."]);
        exit;
    }

    // Prepara e executa a inserção com senha criptografada
    $stmt = $db->prepare("INSERT INTO usuarios (nome, email, password) VALUES (:nome, :email, :senha)");
    $stmt->bindParam(':nome', $data->nome);
    $stmt->bindParam(':email', $data->email);
    $senhaCriptografada = password_hash($data->password, PASSWORD_DEFAULT);
    $stmt->bindParam(':senha', $senhaCriptografada);

    $stmt->execute();

    echo json_encode(["status" => "success", "message" => "Usuário cadastrado com sucesso."]);
} catch (PDOException $e) {
    error_log($e->getMessage());  // Loga no servidor
    echo json_encode(["status" => "error", "message" => "Erro ao cadastrar: " . $e->getMessage()]);
}
?>