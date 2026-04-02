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

require_once BASE_PATH . 'app/DAO/BandGroupsDAO.php';
require_once BASE_PATH . 'app/DAO/InstrumentsDAO.php';
require_once BASE_PATH . 'app/DAO/MusicalScoresDAO.php';
require_once BASE_PATH . 'app/DAO/MusiciansDAO.php';
require_once BASE_PATH . 'app/DAO/NewsDAO.php';
require_once BASE_PATH . 'app/DAO/PresentationsDAO.php';
require_once BASE_PATH . 'app/DAO/RegencyDAO.php';

// Conexão única compartilhada entre todos os DAOs.
$conn = Database::getConnection();

// Instâncias globais para uso nas páginas e validadores.
$bandGroupsDAO = new BandGroupsDAO($conn);
$instrumentsDAO = new InstrumentsDAO($conn);
$musicalScoresDAO = new MusicalScoresDAO($conn);
$musiciansDAO = new MusiciansDAO($conn);
$newsDAO = new NewsDAO($conn);
$presentationsDAO = new PresentationsDAO($conn);
$regencyDAO = new RegencyDAO($conn);
?>
