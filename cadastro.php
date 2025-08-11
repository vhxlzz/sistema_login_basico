<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

$nome = trim($data['nome'] ?? '');
$email = trim($data['email'] ?? '');
$senha = trim($data['senha'] ?? '');

if (!$nome || !$email || !$senha) {
  echo json_encode(['sucesso' => false, 'mensagem' => 'Preencha todos os campos.']);
  exit;
}

$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

$stmt_check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
  echo json_encode(['sucesso' => false, 'mensagem' => 'Email já cadastrado.']);
  exit;
}

$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $email, $senha_hash);

if ($stmt->execute()) {
  echo json_encode(['sucesso' => true, 'mensagem' => 'Cadastro realizado com sucesso.']);
} else {
  echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao cadastrar.']);
}
?>
