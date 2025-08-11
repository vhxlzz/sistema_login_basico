<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

$email = trim($data['email'] ?? '');
$senha = trim($data['senha'] ?? '');

if (!$email || !$senha) {
  echo json_encode(['sucesso' => false, 'mensagem' => 'Preencha todos os campos.']);
  exit;
}

$stmt = $conn->prepare("SELECT nome, senha FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $usuario = $result->fetch_assoc();
  if (password_verify($senha, $usuario['senha'])) {
    echo json_encode(['sucesso' => true, 'mensagem' => 'Login realizado com sucesso.', 'nome' => $usuario['nome']]);
  } else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Senha incorreta.']);
  }
} else {
  echo json_encode(['sucesso' => false, 'mensagem' => 'Usuário não encontrado.']);
}
?>
