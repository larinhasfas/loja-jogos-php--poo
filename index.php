<?php
// Ativadores de erro para te ajudar no trabalho
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/config/db.php';

// Inicializa o banco
try {
    Database::getConnection();
} catch (Exception $e) {
    die("Erro na conexão do banco: " . $e->getMessage());
}

// Se não passar nada na URL, joga direto para a tela de produtos para facilitar sua apresentação
$controller = $_GET['controller'] ?? 'produto';
$action = $_GET['action'] ?? 'index';

// Carregar apenas os controllers que existem na sua pasta controladores
switch ($controller) {
    case 'produto':
        require_once __DIR__ . '/controllers/ProdutoController.php';
        $c = new ProdutoController();
        break;

    case 'venda':
        if (file_exists(__DIR__ . '/controllers/VendaController.php')) {
            require_once __DIR__ . '/controllers/VendaController.php';
            $c = new VendaController();
        } else {
            die("O arquivo VendaController.php não foi encontrado na pasta controllers.");
        }
        break;

    case 'relatorio':
        if (file_exists(__DIR__ . '/controllers/RelatorioController.php')) {
            require_once __DIR__ . '/controllers/RelatorioController.php';
            $c = new RelatorioController();
        } else {
            die("O arquivo RelatorioController.php não foi encontrado na pasta controllers.");
        }
        break;

    case 'usuario':
        if (file_exists(__DIR__ . '/controllers/UsuarioController.php')) {
            require_once __DIR__ . '/controllers/UsuarioController.php';
            $c = new UsuarioController();
        } else {
            die("O arquivo UsuarioController.php não foi encontrado na pasta controllers.");
        }
        break;

    default:
        die("Controlador inválido para o sistema.");
}

// Executar ação
if (!method_exists($c, $action)) {
    die("A ação '{$action}' não existe dentro do controlador escolhido.");
}

$c->$action();