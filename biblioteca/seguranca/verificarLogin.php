<?php

require_once BIBLIOTECA_DIR . "seguranca/seguranca.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['fazendo_login'])) {
//        session_start();
        iniciarSessao();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION) && $_SESSION['autenticado'] === FALSE) {
            $_SERVER['REQUEST_METHOD'] = NULL;

            $email = (isset($_POST['login'])) ? $_POST['login'] : '';
            $senha = (isset($_POST['senha'])) ? md5($_POST['senha']) : '';
            $usuario = new Usuario();
            $usuario->set_email($email);
            $usuario->set_senha($senha);

            if (autenticaUsuario($usuario)) {
                sistemaDAO::registrarAccesso($_SESSION['usuario']->get_id());
                header("Location: " . WEB_SERVER_ADDRESS . "index.php");
            } else {
                // O usuário e/ou a senha são inválidos, manda de volta pro form de login
                expulsaVisitante("Usuário ou senha inválidos.");
            }
        }
    }
}
?>
