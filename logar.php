<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel='stylesheet' href='publico/css/mainStyle.css' />  
        <link rel='stylesheet' href='publico/css/login.css' />
        <!--<link rel='stylesheet' href='publico/css/bootstrap.css' />-->
        <title>Autenticação</title>
    </head>
    <body>
        <?php
        session_start();
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
                <form class="table centered" name="identificacao" action="./biblioteca/seguranca/seguranca.php" method="post">
                    <fieldset>
                        <div class="line">
                            <label>Email</label>
                            <input type="text" name="login">
                        </div>
                        <div class="line">
                            <label>Senha</label>
                            <input type="password" name="senha" >
                        </div>
                        <input name="identificacao" type="submit" value="Entrar" >
                    </fieldset>
                    <a href="#"><p class="centeredText">Esqueci minha senha.</p></a>
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
        <?php if (!isset($_GET['m'])): ?>
            <div id="apoio">
                <h3>Apoio:</h3>
                <div id="uab"></div>
                <div id="capes"></div>
            </div>
            <div id="footer" >
                <p class="centeredText">Copyright &copy; 2012 - Desenvolvido por <a href="http://cead.unifal-mg.edu.br" target="_blank" title="Cead home page">CEAD</a></label>
            </div>
        <?php endif; ?>
    </body>
</html>