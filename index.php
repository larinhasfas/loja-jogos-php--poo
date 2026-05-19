<?php
session_start();
require_once __DIR__ . '/config/db.php';
// (Opcional) teste silencioso de bootstrap
Database::getConnection();
// Roteamento simples via GET
$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'form';
// Carregar controller
switch ($controller) {
case 'auth':
require_once __DIR__ . '/controllers/AuthController.php';
$c = new AuthController();
break;
case 'produto':
require_once __DIR__ . '/controllers/ProdutoController.php';
$c = new ProdutoController();
break;
case 'entrada':
require_once __DIR__ . '/controllers/EntradaController.php';
$c = new EntradaController();
break;
case 'venda':
require_once __DIR__ . '/controllers/VendaController.php';
$c = new VendaController();
break;
case 'relatorio':

require_once __DIR__ . '/controllers/RelatorioController.php';
$c = new RelatorioController();
break;
default:
die("Controller inválido.");
}
// Executar ação
if (!method_exists($c, $action)) {
die("Ação inválida.");
}
$c->$action();