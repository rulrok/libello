<?php
ob_start();
require_once './biblioteca/configuracoes.php';
require_once './biblioteca/seguranca/seguranca.php';

if (sessaoIniciada()) {
    ob_clean();
    header("Location: index.php");
    ob_end_flush();
    exit;
}

$email = filter_has_var(INPUT_GET, 'email') ? filter_input(INPUT_GET, 'email') : "";
?>
<!DOCTYPE html">
<html>
    <head>
        <title class="tituloFixo">Autenticação</title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <!-- FOLHAS DE ESTILO -->
        <link rel='stylesheet' href='publico/css/bootstrap.css' />
        <link rel='stylesheet' href='publico/css/mainStyle.css' />  
        <link rel='stylesheet' href='publico/css/login.css' />
        <link rel="stylesheet" media="screen" href="publico/css/browser-detection.css" />

        <!-- SCRIPTS -->

        <script src="publico/js/jquery/jquery-1.9.1.js"></script>
        <script src="publico/js/jquery/jquery-ui.js"></script>
        <script src="publico/js/jquery/jquery.center.js"></script>
        <script src="publico/js/browser-detection.js"></script>


    </head>
    <body>
        <?php
        $ocultarDetalhes = false;
        if ($_SERVER['HTTP_ACCEPT'] != "*/*") {
            $ocultarDetalhes = true;
        }
        ?>
        <div id="login" class="centralizado">
            <h1 class="textoCentralizado"><?php echo APP_NAME; ?></h1>
            <h2 class="textoCentralizado">Login de Acesso</h2>
            <div id="logo_esquerda_paginas_iniciais"></div>
            <div id="logo_direita_paginas_iniciais"></div>
            <div id="loginArea">
                <form class="tabela centralizado" name="identificacao" action="./biblioteca/seguranca/verificarLogin.php" method="post">
                    <fieldset>
                        <input hidden type="checkbox" class="hidden" id="fazendo_login" name="fazendo_login" checked>
                        <input hidden type="text" class="hidden" id="alvo" name="alvo" >
                        <div class="control-group">
                            <!--<label for="email">Email</label>-->
                            <input class="input-large" <?php echo empty($email) ? "autofocus" : ""; ?> required type="email" id="email" name="login" placeholder="Email" value="<?php echo $email; ?>">
                        </div>
                        <div class="control-group">
                            <!--<label for="password">Senha</label>-->
                            <input class="input-large" <?php echo empty($email) ? "" : "autofocus"; ?> required type="password" id="password" name="senha" placeholder="Senha">
                        </div>
                        <br/>
                        <div class="control-group">
                            <button class="btn btn-right btn-info" name="identificacao" type="submit">Entrar</button>
                            <?php if ($ocultarDetalhes): ?>
                                <a href="lembrarSenha.php" class="btn btn-link">Esqueci a senha</a>
                            <?php endif; ?>
                        </div>
                    </fieldset>

                </form>
            </div>
            <div class="error textoCentralizado">
                <?php
                if (filter_has_var(INPUT_GET, 'm')) {
                    echo filter_input(INPUT_GET, 'm');
                }
                ?>
            </div>
        </div>
        <?php if ($ocultarDetalhes): ?>
            <?php require_once 'apoio.php'; ?>
            <?php require_once 'footer.php'; ?>
        <?php endif; ?>
        <script>
            $(document).ready(function() {
                document.paginaAlterada = false;
                $("#alvo").prop("value", location.hash);
            });
        </script>
    </body>
</html>