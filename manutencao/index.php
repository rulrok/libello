<?php
//include_once './../biblioteca/configuracoes.php';
$ocultarDetalhes = true;
$a = print_r($_SERVER, true);
if ($_SERVER['HTTP_ACCEPT'] != "*/*") {
    $ocultarDetalhes = false;
}

ob_start();
require_once APP_LIBRARY_ABSOLUTE_DIR . 'seguranca/seguranca.php';

if (!file_exists(ROOT . 'manutencao.php')) {
    ob_clean();
    header("Location: " . WEB_SERVER_ADDRESS);
    ob_end_flush();
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Manutenção</title>

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
        <div id="login" class="container-fluid">
            <div class="row-fluid">
                <div style="padding-top: 35px;">
                    <div class="span6" style="padding-right: 30px;">
                        <h1 class="text-right"><?php echo APP_NAME; ?></h1>
                        <h2 class="text-right">Modo de manutenção</h2>
                    </div>
                    <div class="span6">
                        <p>O portal está em manutenção</p>
                        <br/>
                        <p>Pedimos que <a href="<?php echo WEB_SERVER_ADDRESS; ?>/logar">tente acessar</a> novamente dentro de alguns minutos</p>
                    </div>
                </div>
                <div class="error text-center">
                    <?php
                    if (filter_has_var(INPUT_GET, 'm')) {
                        echo filter_input(INPUT_GET, 'm');
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php if (!$ocultarDetalhes): ?>
            <?php require_once ROOT . 'apoio.php'; ?>
            <?php require_once ROOT . 'footer.php'; ?>
        <?php endif; ?>
    </body>
</html>