<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$user = 'root';
$pass = ''; // coloque a senha do seu MySQL aqui, se tiver
$db = 'sistema_login_basico';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die(json_encode(['sucesso' => false, 'mensagem' => 'Erro na conexão: ' . $conn->connect_error]));
}
?>
