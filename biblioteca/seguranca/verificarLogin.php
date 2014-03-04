<?php

require_once '../configuracoes.php';
require_once BIBLIOTECA_DIR . "seguranca/seguranca.php";
require_once BIBLIOTECA_DIR . 'seguranca/criptografia.php';

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
    if (filter_has_var(INPUT_POST, 'fazendo_login')) {
        iniciarSessao();
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST' && isset($_SESSION) && $_SESSION['autenticado'] === FALSE) {
            $_SERVER['REQUEST_METHOD'] = NULL;

            $email = (isset($_POST['login'])) ? $_POST['login'] : '';
            $senha = (isset($_POST['senha'])) ? encriptarSenha($_POST['senha']) : '';
            $usuario = new Usuario();
            $usuario->set_email($email);
            $usuario->set_senha($senha);

            if (autenticaUsuario($usuario)) {
                (new sistemaDAO())->registrarAccesso(obterUsuarioSessao()->get_idUsuario());
                header("Location: " . WEB_SERVER_ADDRESS . filter_input(INPUT_POST, 'alvo'));
            } else {
                // O usuário e/ou a senha são inválidos, manda de volta pro form de login
                expulsaVisitante('Usuário ou senha inválidos.');
            }
        } elseif (isset($_SESSION) && $_SESSION['autenticado'] === TRUE) {
            header('Location: ' . WEB_SERVER_ADDRESS);
        }
    }
} else {
    header('Location: ' . WEB_SERVER_ADDRESS);
}
?>
