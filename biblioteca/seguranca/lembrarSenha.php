<html>
    <head>
        <meta charset="UTF-8"/>
    </head>

    <?php
    require_once '../configuracoes.php';
    require_once APP_LOCATION . "modelo/dao/usuarioDAO.php";

    if (isset($_POST['email']) && $_POST['email'] != NULL && $_POST['email'] != "") :
        $email = $_POST['email'];
        $usuario = usuarioDAO::recuperarUsuario($email);
        if ($usuario != NULL) :
            $id = $usuario->get_id();
            usuarioDAO::gerarTolkenRecuperarSenha($email);
            $tolken = usuarioDAO::consultarTolkenRecuperarSenha($id);

//            $destinatario = "Reuel <rulrok@gmail.com>";
            $link = WEB_SERVER_NAME."lembrarSenha.php?tolken=".$tolken;
            $assunto = "Alteração de senha";
            $mensagem = "<p>Você está recebendo esse e-mail pois não se lembra mais da sua senha. Clique no link abaixo para redefinir a sua senha:</p><br/>";
            $mensagem .= "<a href=\"$link\">$link</a><br/>";
            $mensagem .= "<br/>";
            $mensagem .= "<p>Caso não tenha solicitado a mudança de senha, por favor, apenas desconsidere esse email.</p>";
            $mensagem .= "<p>Se você estiver passando por dificuldades técnicas, entre em contato pelo email <suporte>.</p>";


            //SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
            date_default_timezone_set('America/São Paulo');

            require BIBLIOTECA_DIR . 'PHPMailer/class.phpmailer.php';

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = "<algum email gmail>";
            $mail->Password = "<senha>";
            $mail->SetFrom('cead.suporte@unifal-mg.edu.br', 'CEAD');
            $mail->AddAddress('a11021@bcc.unifal-mg.edu.br', 'Reuel Ramos');
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
            ?>
            <p>Verifique se seu email está correto!</p>
        <?php
        endif;
    elseif (isset($_POST['novaSenha']) && $_POST['novaSenha'] != NULL && $_POST['novaSenha'] != ""):
        $tolken = $_POST['tolken'];
        $novaSenha = $_POST['novaSenha'];

        $idUsuario = usuarioDAO::consultarIDUsuario_RecuperarSenha($tolken);
        $email = usuarioDAO::descobrirEmail($idUsuario);
        $usuario = new Usuario();
        $usuario->set_senha(md5($novaSenha));
        usuarioDAO::atualizar($email, $usuario);
        ?>
        Senha alterada com sucesso!
        <?php
    else:
        header("Location: " . WEB_SERVER_NAME);
    endif;
    ?>
</html>