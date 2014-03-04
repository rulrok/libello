<?php

require_once '../configuracoes.php';
require_once APP_LOCATION . "modelo/dao/usuarioDAO.php";
require_once BIBLIOTECA_DIR . 'seguranca/criptografia.php';

if (filter_has_var(INPUT_POST, 'email') && filter_input(INPUT_POST, 'email') != NULL && filter_input(INPUT_POST, 'email') != "") :
    $email = filter_input(INPUT_POST, 'email');
    $usuarioDAO = new usuarioDAO();
    $usuario = $usuarioDAO->recuperarUsuario($email);
    if ($usuario !== null) :
        $id = $usuario->get_idUsuario();
        $usuarioDAO->gerarTolkenRecuperarSenha($email);
        $tolken = $usuarioDAO->consultarTolkenRecuperarSenha($id);

        $link = WEB_SERVER_ADDRESS . "lembrarSenha.php?tolken=" . $tolken;
        $assunto = "Alteração de senha";
        $mensagem = "<p>Você está recebendo esse e-mail pois fez uma solicitação de recuperação da sua senha. Clique no link abaixo para redefinir a sua senha:</p><br/>";
        $mensagem .= "<a href=\"$link\">$link</a><br/>";
        $mensagem .= "<br/>";
        $mensagem .= "<p>Caso não tenha solicitado a mudança de senha, por favor, apenas desconsidere esse email.</p>";
        $mensagem .= "<p>Se você estiver passando por dificuldades técnicas, entre em contato com algum administrador.</p>";


        //SMTP needs accurate times, and the PHP time zone MUST be set
        //This should be done in your php.ini, but this is how to do it if you don't have access to that
        date_default_timezone_set(APP_TIME_ZONE);

        require BIBLIOTECA_DIR . 'PHPMailer/class.phpmailer.php';

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = SMTP_SERVER_IP;
        $mail->Port = SMTP_SERVER_PORT;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_SERVER_EMAIL;
        $mail->Password = SMTP_SERVER_PASSWORD;
        $mail->SetFrom(SMTP_SERVER_EMAIL, 'CEAD - NOREPLY');
        $mail->AddAddress($usuario->get_email(), $usuario->get_PNome() . " " . $usuario->get_UNome());
        $mail->Subject = $assunto;
        $mail->MsgHTML($mensagem);
        $mail->AltBody = $mensagem;
        $mail->CharSet = "UTF8";

        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Email enviado. Consulte sua caixa de entrada.";
        }
    else :
        echo "<p>Verifique se seu email está correto!</p>";

    endif;
elseif (filter_has_var(INPUT_POST, 'novaSenha') && filter_input(INPUT_POST, 'novaSenha') != NULL && filter_input(INPUT_POST, 'novaSenha') != ""):
    $tolken = filter_input(INPUT_POST, 'tolken');
    $novaSenha = filter_input(INPUT_POST, 'novaSenha');

    try {
        $usuarioDAO = new usuarioDAO();
        $idUsuario = $usuarioDAO->consultarIDUsuario_RecuperarSenha($tolken);
        $email = $usuarioDAO->descobrirEmail($idUsuario);
        $usuario = new Usuario();
        $usuario->set_senha(encriptarSenha($novaSenha));
        $usuarioDAO->atualizar($email, $usuario);
        $usuarioDAO->removerTolken($tolken);

        echo "<p>Senha alterada com sucesso!</p>";
    } catch (Exception $e) {
        echo "<p>Tolken inválido</p>";
    }
else:
    header("Location: " . WEB_SERVER_ADDRESS);
endif;
?>