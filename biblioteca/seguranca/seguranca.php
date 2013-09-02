<?php

require_once __DIR__ . '/../configuracoes.php';
require_once BIBLIOTECA_DIR . 'bancoDeDados/PDOconnectionFactory.php';
require ROOT . '/app/modelo/vo/Usuario.php';
require ROOT . '/app/modelo/dao/sistemaDAO.php';

/**
 * Inicia um sessão, com o usuário inicialmente não autenticado.
 * @return type
 */
function iniciarSessao() {
    if (isset($_SESSION['iniciada']) && $_SESSION['iniciada'] === true) {
        return;
    } else {
        session_start();
        $_SESSION['iniciada'] = true;
        $_SESSION['autenticado'] = false;
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
    header("Location: " . WEB_SERVER_NAME . "logar.php" . ($msg_erro != null ? "?m=" . $msg_erro : ""),true);
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
                    $_SESSION['autenticado'] = true;

                    $_SESSION['idUsuario'] = $ret[0]->get_id();
                    $_SESSION['login'] = $ret[0]->get_email();
                    $_SESSION['senha'] = $ret[0]->get_senha();
                    $_SESSION['nome'] = $ret[0]->get_PNome();
                    $_SESSION['sobrenome'] = $ret[0]->get_UNome();
                    $_SESSION['papel'] = $ret[0]->get_papel();
                    $_SESSION['email'] = $ret[0]->get_email();
                    $_SESSION['dataNascimento'] = $ret[0]->get_dataNascimento();
                    

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

//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['autenticado'] === FALSE) {
    iniciarSessao();
    $_SERVER['REQUEST_METHOD'] = NULL;

    $email = (isset($_POST['login'])) ? $_POST['login'] : '';
    $senha = (isset($_POST['senha'])) ? md5($_POST['senha']) : '';
    $usuario = new Usuario();
    $usuario->set_email($email);
    $usuario->set_senha($senha);

    if (autenticaUsuario($usuario)) {
        sistemaDAO::registrarAccesso($_SESSION['idUsuario']);
        header("Location: ../../index.php");
    } else {
        // O usuário e/ou a senha são inválidos, manda de volta pro form de login
        expulsaVisitante("Usuário ou senha inválidos.");
    }
}
?>
