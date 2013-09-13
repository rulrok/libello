<?php

require_once __DIR__ . '/../configuracoes.php';
require_once BIBLIOTECA_DIR . 'bancoDeDados/PDOconnectionFactory.php';
require_once APP_LOCATION . 'modelo/vo/Usuario.php';
require_once APP_LOCATION . 'modelo/dao/sistemaDAO.php';

session_start();
/**
 * Inicia um sessão, com o usuário inicialmente não autenticado.
 * @return type
 */
function iniciarSessao() {
    if (isset($_SESSION['iniciada']) && $_SESSION['iniciada'] === true) {
        return;
    } else {
        if (session_status() === PHP_SESSION_NONE) {
//            session_start();
        }
        $_SESSION['iniciada'] = true;
        $_SESSION['autenticado'] = false;
    }
}

function sessaoIniciada() {
//    session_start();
    if (session_status() === PHP_SESSION_NONE) {
        return false;
    } else {
        return isset($_SESSION['iniciada']) && $_SESSION['autenticado'] === true;
    }
}

function obterUsuarioSessao(){
    if (sessaoIniciada()){
        $usuario = $_SESSION['usuario'];
        return $usuario;
    } else {
        return NULL;
    }
}

/**
 * Encerra a sessão e todos os seus dados.
 */
function encerrarSessao() {
    if (isset($_SESSION['iniciada']) && $_SESSION['iniciada'] === true) {
        session_destroy();
    }
}

/**
 * Verifica se é um usuário logado que está a obter acesso a alguma página.
 */
function protegePaginaLogado() {
    if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] === false) {
        expulsaVisitante();
    }
}

/**
 * Encerra a sessão e manda a pessoa para a página principal.
 */
function expulsaVisitante($msg_erro = null) {
    encerrarSessao();
//    ob_start();
    header("Location: " . WEB_SERVER_ADDRESS . "logar.php" . ($msg_erro != null ? "?m=" . $msg_erro : ""), true);
//    ob_end_flush();
    exit;
}

/**
 * Autentica um usuário no sistema.
 * 
 * @param Usuario $user Um objeto usuário com login e senha preenchidos.
 * @return boolean Verdadeiro se o usuário existir no banco de dados, falso caso contrário
 */
function autenticaUsuario(Usuario $user) {
    if (($con = PDOconnectionFactory::getConection()) != null) {
        //$con = $_SESSION['conexao'];

        if ($user->get_email() !== null && $user->get_email() !== '' && $user->get_senha() !== null && $user->get_senha() !== '') {
            try {
                $query = $con->prepare("SELECT * FROM usuario WHERE email = :email AND senha = :senha AND ativo = 1");
                $query->execute(array('email' => $user->get_email(), 'senha' => $user->senha));
                $ret = $query->fetchAll(PDO::FETCH_CLASS, 'Usuario');

                if (sizeof($ret) === 1) {
                    $_SESSION['usuario'] = $ret[0];
                    $_SESSION['autenticado'] = true;

                    return true;
                } else {
                    expulsaVisitante("Usuário ou senha incorretos.");
                    return false;
                }
            } catch (PDOException $e) {
                expulsaVisitante($e);
                return false;
            }
        } else {
            expulsaVisitante("Usuário e senha são requeridos.");
            return false;
        }
    } else {
        expulsaVisitante("Não foi possível se conectar ao banco de dados");
        return false;
    }
}

?>
