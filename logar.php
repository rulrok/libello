<?php
ob_start();
require_once './biblioteca/configuracoes.php';
if (isset($_SESSION['iniciada']) && $_SESSION['iniciada'] === true && $_SESSION['autenticado'] === TRUE) {
    header("Location: index.php");
} else {
    $_SESSION['autenticado'] = false;
}
?>
<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel='stylesheet' href='publico/css/bootstrap.css' />
        <link rel='stylesheet' href='publico/css/mainStyle.css' />  
        <link rel='stylesheet' href='publico/css/login.css' />
        <title class="tituloFixo">Autenticação</title>
        <link rel="stylesheet" type="text/css" media="screen" href="publico/css/browser-detection.css" />
<!--        <script src="http://ie.microsoft.com/testdrive/HTML5/CompatInspector/inspector.js"></script>-->
        <script src="publico/js/jquery/jquery-1.9.1.js"></script>
        <script>
            jQuery.fn.center = function() {
                this.css("position", "absolute");
                this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
                        $(window).scrollTop()) + "px");
                this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
                        $(window).scrollLeft()) + "px");
                return this;
            };
            document.paginaAlterada = false;
        </script>
        <script src="publico/js/jquery/jquery-ui.js"></script>
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
            <h1 class="textoCentralizado">Sistema de Controle CEAD</h1>
            <h2 class="textoCentralizado">Login de Acesso</h2>
            <div id="unifal"></div>
            <div id="cead"></div>
            <div id="loginArea">
                <form class="tabela centralizado" name="identificacao" action="./biblioteca/seguranca/verificarLogin.php" method="post">
                    <fieldset>
                        <input hidden type="checkbox" class="hidden" id="fazendo_login" name="fazendo_login" checked>
                            <input hidden type="text" class="hidden" id="alvo" name="alvo" >
                                <div class="line">
                                    <label for="email">Email</label>
                                    <input autofocus="true" required type="email" id="email" name="login">
                                </div>
                                <div class="line">
                                    <label for="password">Senha</label>
                                    <input required type="password" id="password" name="senha" >
                                </div>
                                <br/>
                                <button class="btn btn-right btn-info" name="identificacao" type="submit">Entrar</button>
                                <?php if ($ocultarDetalhes): ?>
                                    <a href="lembrarSenha.php" style="text-decoration: underline;color: #0088cc; cursor: help;">Esqueci a senha</a>
                                <?php endif; ?>
                                </fieldset>

                                </form>
                                </div>
                                <div class="error textoCentralizado">
                                    <?php
                                    if (isset($_GET['m'])) {
                                        echo $_GET['m'];
                                    }
                                    ?>
                                </div>
                                </div>
                                <?php if ($ocultarDetalhes): ?>
                                    <div id="apoio">
                                        <h3>Apoio:</h3>
                                        <a href="http://www.uab.capes.gov.br/" target="_blank"><div id="uab"></div></a>
                                        <a href="http://www.capes.gov.br/" target="_blank"><div id="capes"></div></a>
                                    </div>
                                    <div id="footer" >
                                        <p class="textoCentralizado">Copyright &copy; 2012 - 2014 | Desenvolvido por <a href="http://cead.unifal-mg.edu.br" target="_blank" title="Cead home page">CEAD</a> | Versão <?php echo APP_VERSION; ?></p>
                                    </div>
                                <?php endif; ?>
                                <script>
            $(document).ready(function() {
                document.paginaAlterada = false;
                $("#alvo").prop("value", location.hash);
            });
                                </script>
                                </body>
                                </html>