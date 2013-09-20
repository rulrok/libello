<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel='stylesheet' href='publico/css/bootstrap.css' />
        <link rel='stylesheet' href='publico/css/mainStyle.css' />  
        <link rel='stylesheet' href='publico/css/login.css' />
        <title class="tituloFixo">Autenticação</title>
<!--        <script type="text/javascript">
            var $buoop = {vs: {i: 9, f: 15, o: 11, s: 5, n: 9}}
            $buoop.ol = window.onload;
            window.onload = function() {
                try {
                    if ($buoop.ol)
                        $buoop.ol();
                } catch (e) {
                }
                var e = document.createElement("script");
                e.setAttribute("type", "text/javascript");
                e.setAttribute("src", "http://browser-update.org/update.js");
                document.body.appendChild(e);
            };
        </script> -->
        <link rel="stylesheet" type="text/css" media="screen" href="http://www.devslide.com/public/labs/browser-detection/browser-detection.css" />
        <script src="publico/js/jquery/jquery-1.9.1.js"></script>
        <script src="publico/js/mainScript.js"></script>
        <script src="publico/js/jquery/jquery-ui.js"></script>
        <script src="publico/js/browser-detection.js" />
        <script>
            var displayPoweredBy = false;
            
        </script>
    </head>
    <body>
        <?php
        $ocultarDetalhes = false;
        if ($_SERVER['HTTP_ACCEPT'] != "*/*") {
            $ocultarDetalhes = true;
        }
//        if (session_status() === PHP_SESSION_NONE) {
//            session_start();
//        }
        if (isset($_SESSION['iniciada']) && $_SESSION['iniciada'] === true && $_SESSION['autenticado'] === TRUE) {

            header("Location: index.php");
        } else {
            $_SESSION['autenticado'] = false;
        }
        ?>
        <div id="login" class="centered">
            <h1 class="centeredText">Sistema de Controle CEAD</h1>
            <h2 class="centeredText">Login de Acesso</h2>
            <div id="unifal"></div>
            <div id="cead"></div>
            <div id="loginArea">
                <form class="table centered" name="identificacao" action="./biblioteca/seguranca/verificarLogin.php" method="post">
                    <fieldset>
                        <input hidden type="checkbox" id="fazendo_login" name="fazendo_login" checked/>
                        <div class="line">
                            <label>Email</label>
                            <input required type="text" name="login">
                        </div>
                        <div class="line">
                            <label>Senha</label>
                            <input required type="password" name="senha" >
                        </div>
                        <br/>
                        <input class="btn btn-right btn-info" name="identificacao" type="submit" value="Entrar" >
                            <?php if ($ocultarDetalhes): ?>
                                <a class="btn"href="lembrarSenha.php">Esqueci a senha</a>
                            <?php endif; ?>
                    </fieldset>

                </form>
            </div>
            <div class="error centeredText">
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
                <div id="uab"></div>
                <div id="capes"></div>
            </div>
            <div id="footer" >
                <p class="centeredText">Copyright &copy; 2012 - 2013 | Desenvolvido por <a href="http://cead.unifal-mg.edu.br" target="_blank" title="Cead home page">CEAD</a></label>
            </div>
        <?php endif; ?>
    </body>
</html>