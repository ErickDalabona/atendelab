<?php

require_once __DIR__ . '/app/Middleware/auth.php';
require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/UsuariosController.php';
require_once __DIR__ . '/app/Controllers/PessoasController.php';
require_once __DIR__ . '/app/Controllers/TiposAtendimentosController.php';
require_once __DIR__ . '/app/Controllers/AtendimentosController.php';
require_once __DIR__ . '/app/Controllers/FrontendController.php';
require_once __DIR__ . '/app/Controllers/DashboardController.php';

$controller = $_GET['controller'] ?? 'auth';
$action     = $_GET['action']     ?? 'login';

if ($controller === 'auth') {
    $auth = new AuthController();
    switch ($action) {
        case 'login':     $auth->exibirLogin(); break;
        case 'entrar':    $auth->entrar();      break;
        case 'dashboard': exigirAutenticacao(); $auth->dashboard(); break;
        case 'logout':    $auth->logout();      break;
        default: http_response_code(404); echo 'Acao nao encontrada.';
    }
    exit;
}

exigirAutenticacao();

switch ($controller) {
    case 'usuarios':
        $obj = new UsuariosController();
        if (!method_exists($obj, $action)) { http_response_code(404); exit('Acao nao encontrada.'); }
        $obj->$action();
        break;

    case 'pessoas':
        $obj = new PessoasController();
        switch ($action) {
            case 'listar':      $obj->listar();      break;
            case 'buscar':
            case 'buscarPorId': $obj->buscarPorId(); break;
            case 'criar':       $obj->criar();       break;
            case 'atualizar':   $obj->atualizar();   break;
            case 'inativar':    $obj->inativar();    break;
            default: http_response_code(404); echo json_encode(['erro' => 'Acao de pessoas nao encontrada.']);
        }
        break;

    case 'tipos':
        $obj = new TiposAtendimentosController();
        switch ($action) {
            case 'listar':      $obj->listar();      break;
            case 'buscar':
            case 'buscarPorId': $obj->buscarPorId(); break;
            case 'criar':       $obj->criar();       break;
            case 'atualizar':   $obj->atualizar();   break;
            case 'inativar':    $obj->inativar();    break;
            default: http_response_code(404); echo json_encode(['erro' => 'Acao de tipos nao encontrada.']);
        }
        break;

    case 'atendimentos':
        $obj = new AtendimentosController();
        switch ($action) {
            case 'listar':           $obj->listar();           break;
            case 'visualizar':       $obj->visualizar();       break;
            case 'criar':            $obj->criar();            break;
            case 'alterarStatus':
            case 'atualizarStatus':  $obj->alterarStatus();   break;
            case 'opcoesFormulario': $obj->opcoesFormulario(); break;
            default: http_response_code(404); echo json_encode(['erro' => 'Acao de atendimentos nao encontrada.']);
        }
        break;

    case 'dashboard':
        $obj = new DashboardController();
        switch ($action) {
            case 'resumo': $obj->resumo(); break;
            default: http_response_code(404); echo json_encode(['erro' => 'Acao de dashboard nao encontrada.']);
        }
        break;

    case 'frontend':
        $obj = new FrontendController();
        switch ($action) {
            case 'pessoas':      $obj->pessoas();      break;
            case 'tipos':        $obj->tipos();        break;
            case 'atendimentos': $obj->atendimentos(); break;
            default: http_response_code(404); exit('Pagina nao encontrada.');
        }
        break;

    default:
        http_response_code(404);
        exit('Controller nao encontrado.');
}