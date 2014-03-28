<?php

require_once 'class.phpmailer.php';
/**
 * Description of Email
 *
 * @author reuel
 */
class Email {

    const EMAIL_FALHA_ENVIAR = 0;
    const EMAIL_ENVIADO = 1;
    const EMAIL_INDEFINIDO = -1;

    private $destinatarioEmail = null;
    private $destinatarioNome = null;
    private $assunto = null;
    private $mensagem = null;
    private $STATUS = self::EMAIL_INDEFINIDO;

    /**
     * Configura o destinatário para a mensagem
     * 
     * @param string $email
     * @param string $nome
     */
    public function definirDestinatario($email, $nome) {
        $emailValido = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$emailValido) {
            return FALSE;
        } else {
            $this->destinatarioEmail = $emailValido;
            $this->destinatarioNome = $nome;
            return TRUE;
        }
    }

    /**
     * Define o assunto para ser o título do email, ou caso contrário, o email irá
     * com o assunto padrão "Sem assunto".
     * 
     * @param type $assunto
     */
    public function definirAssunto($assunto = "Sem assunto") {
        $this->assunto = $assunto;
    }

    /**
     * Corpo do email, que pode ser uma string com marcações HTML.
     * 
     * @param string $corpoEmail
     */
    public function definirMensagem($corpoEmail) {
        $this->mensagem = $corpoEmail;
    }

    public function enviar() {
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
        $mail->AddAddress($this->destinatarioEmail, $this->destinatarioNome);
        $mail->Subject = $this->assunto;
        $mail->MsgHTML($this->mensagem);
        $mail->AltBody = $this->mensagem;
        $mail->CharSet = "UTF8";

        try {
            if ($mail->Send()) {
                $this->STATUS = self::EMAIL_ENVIADO;
            } else {
                $this->STATUS = self::EMAIL_FALHA_ENVIAR;
            }
        } catch (Exception $e) {
                $this->STATUS = self::EMAIL_FALHA_ENVIAR;
        }
    }

    /**
     * Indica se um email foi enviado com sucesso ou não.
     * 
     * @return boolean TRUE para sucesso, FALSE para qualquer outra coisa.
     */
    public function emailFoiEnviado() {
        if ($this->STATUS === self::EMAIL_ENVIADO) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
