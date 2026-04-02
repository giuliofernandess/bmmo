<?php
// Ativa exceções para falhas do MySQLi.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Caminhos globais do projeto.
define('BASE_URL', '/bmmo/');
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/bmmo/');

// Configurações do banco de dados.
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bmmo');

// Dependências de infraestrutura e acesso a dados.
require_once BASE_PATH . 'app/Database/Database.php';
require_once BASE_PATH . 'app/Models/Message.php';

// Conexão única compartilhada entre todos os DAOs.
$conn = Database::getConnection();
?>
