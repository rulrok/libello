<?php
$ocultarDetalhes = true;
$a = print_r($_SERVER, true);
if ($_SERVER['HTTP_ACCEPT'] != "*/*" && $_SERVER['HTTP_ACCEPT'] != "text/html, */*; q=0.01") {
    $ocultarDetalhes = false;
}

ob_start();
require_once './../biblioteca/configuracoes.php';
require_once './../biblioteca/seguranca/seguranca.php';

if (sessaoIniciada()) {
    ob_clean();
    header("Location: " . WEB_SERVER_ADDRESS);
    ob_end_flush();
    exit;
}

$email = filter_has_var(INPUT_GET, 'email') ? filter_input(INPUT_GET, 'email') : "";
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Autenticação</title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <link rel="icon" type="image/ico" href="<?php echo WEB_SERVER_ADDRESS; ?>favicon.ico"/>

        <!-- FOLHAS DE ESTILO -->
        <?php if (!$ocultarDetalhes): ?>
            <link rel='stylesheet' href='<?php echo WEB_SERVER_ADDRESS; ?>publico/css/bootstrap.css' />  
            <link rel='stylesheet' href='<?php echo WEB_SERVER_ADDRESS; ?>publico/css/login.css' />
        <?php else: ?>
            <link rel='stylesheet' href='<?php echo WEB_SERVER_ADDRESS; ?>publico/css/login_alternativo.css' />
            <style>
                #login{
                    border-radius: 10px;
                    -moz-border-radius: 10px;
                    -webkit-border-radius: 10px;
                }
            </style>
        <?php endif; ?>
        <link rel="stylesheet" media="screen" href="<?php echo WEB_SERVER_ADDRESS; ?>publico/css/browser-detection.css" />

        <!-- SCRIPTS -->

        <script src="<?php echo WEB_SERVER_ADDRESS; ?>publico/js/jquery/jquery-1.9.1.js"></script>
        <script src="<?php echo WEB_SERVER_ADDRESS; ?>publico/js/jquery/jquery-ui.js"></script>
        <script src="<?php echo WEB_SERVER_ADDRESS; ?>publico/js/jquery/jquery.center.js"></script>
        <script src="<?php echo WEB_SERVER_ADDRESS; ?>publico/js/browser-detection.js"></script>
        <script>
            $(document).ready(function() {
                document.paginaAlterada = false;
                $("#alvo").prop("value", location.hash);
            });
        </script>

    </head>
    <body>
        <div id="login" class="container-fluid centralizado">
            <div class="row-fluid">
                <div style="padding-top: 35px;">
                    <div class="span6" style="padding-right: 30px;">
                        <h1 class="text-right"><?php echo APP_NAME; ?></h1>
                        <h2 class="text-right">Login de Acesso</h2>
                    </div>
                    <div class="span6">
                        <form class="tabela" action="<?php echo WEB_SERVER_ADDRESS; ?>biblioteca/seguranca/verificarLogin.php" method="post">
                            <input hidden type="checkbox" class="hidden" id="fazendo_login" name="fazendo_login" checked>
                            <input hidden type="text" class="hidden" id="alvo" name="alvo" >
                            <div class="control-group">
                                <input autocomplete="off" <?php echo empty($email) ? "autofocus" : ""; ?> required type="email" id="email" name="login" placeholder="Email" value="<?php echo $email; ?>">
                            </div>
                            <div class="control-group">
                                <input autocomplete="off" <?php echo empty($email) ? "" : "autofocus"; ?> required type="password" id="password" name="senha" placeholder="Senha">
                            </div>
                            <br/>
                            <div class="control-group">
                                <?php if (!$ocultarDetalhes): ?>
                                    <a href="<?php echo WEB_SERVER_ADDRESS; ?>lembrarsenha" class="btn btn-link">Esqueci a senha</a>
                                <?php endif; ?>
                                <button class="btn btn-info pull-right" name="identificacao" type="submit">Entrar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="error text-center">
                    <?php
                    if (filter_has_var(INPUT_GET, 'm')) {
                        if (filter_input(INPUT_GET, 'm') != "Você precisa estar autenticado para realizar essa operação") {
                            echo filter_input(INPUT_GET, 'm');
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php if (!$ocultarDetalhes): ?>
            <?php require_once '../apoio.php'; ?>
            <?php require_once '../footer.php'; ?>
        <?php endif; ?>
    </body>
</html>