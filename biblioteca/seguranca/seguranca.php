<?php

if (!defined("ROOT")) {
    define("ROOT", $_SERVER['DOCUMENT_ROOT'] . "/controle-cead");
    require_once ROOT . '/biblioteca/bancoDeDados/PDOconnectionFactory.php';
    require ROOT . '/app/modelo/vo/Usuario.php';
}

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
        /* try {
          $_SESSION['conexao'] = PDOconnectionFactory::getConection();
          } catch (PDOException $e) {
          expulsaVisitante("Erro desconhecido");
          }
         * 
         */
    }
}

/**
 * Encerra a sessão e todos os seus dados.
 */
function encerrarSessao() {
    if (isset($_SESSION['iniciada']) && $_SESSION['iniciada'] === true) {
        session_destroy();
        exit;
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
    if ($msg_erro === null) {
        //unset($GLOBALS['mensagem_erro']);
    } else {
        $GLOBALS['mensagem_erro'] = $msg_erro;
    }
    encerrarSessao();
    header("Location: logar.php");
    //require ROOT.'/logar.php';
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

        if ($user->get_login() !== null && $user->get_senha() !== null) {
            try {
                $query = $con->prepare("SELECT * FROM usuario WHERE login = :login AND senha = :senha");
                $query->execute(array('login' => $user->get_login(), 'senha' => $user->senha));
                $ret = $query->fetchAll(PDO::FETCH_CLASS, 'Usuario');

                if (sizeof($ret) === 1) {
                    $_SESSION['autenticado'] = true;

                    $_SESSION['idUsuario'] = $ret[0]->get_id();
                    $_SESSION['login'] = $ret[0]->get_login();
                    $_SESSION['nome'] = $ret[0]->get_PNome();
                    $_SESSION['sobrenome'] = $ret[0]->get_UNome();
                    $_SESSION['papel'] = $ret[0]->get_papel();
                    $_SESSION['email'] = $ret[0]->get_email();

                    return true;
                } else {
                    expulsaVisitante("Usuário inexistente");
                    return false;
                }
            } catch (PDOException $e) {
                encerrarSessao();
            }
        } else {
            encerrarSessao();
            return false;
        }
    } else {
        encerrarSessao("Não foi possível se conectar ao banco de dados");
        return false;
    }
}

//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['autenticado'] === FALSE) {
    iniciarSessao();
    $_SERVER['REQUEST_METHOD'] = NULL;

    $login = (isset($_POST['login'])) ? $_POST['login'] : '';
    $senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';
    $usuario = new Usuario();
    $usuario->set_login($login);
    $usuario->set_senha($senha);

    if (autenticaUsuario($usuario)) {
        header("Location: ../../index.php");
    } else {
        // O usuário e/ou a senha são inválidos, manda de volta pro form de login
        expulsaVisitante("Usuário ou senha inválidos.");
    }
}
?>
