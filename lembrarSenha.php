<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel='stylesheet' href='publico/css/bootstrap.css' />
        <link rel='stylesheet' href='publico/css/mainStyle.css' />  
        <link rel='stylesheet' href='publico/css/login.css' />

        <script src="publico/js/jquery/jquery-1.9.1.js"></script>

        <title>Lembrar senha</title>
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
            <h2 class="centeredText">Alterar senha</h2>
            <div id="unifal"></div>
            <div id="cead"></div>
            <div id="loginArea">
                <?php if (!isset($_GET['tolken'])): ?>
                    <form class="table centered" id="ajaxForm" name="identificacao" action="./biblioteca/seguranca/lembrarSenha.php" method="post">
                        <fieldset>
                            <div class="line">
                                <label>Email</label>
                                <input required type="text" name="email">
                            </div>
                            <br/>
                            <a href="logar.php" class="btn">Voltar</a>
                            <input class="btn btn-info" name="identificacao" type="submit" value="Enviar" >
                        </fieldset>
                        <!--<a href="#"><p class="centeredText">Esqueci minha senha</p></a>-->
                    </form>
                <?php else: ?>

                    <form class="table centered" id="ajaxForm" name="identificacao" action="./biblioteca/seguranca/lembrarSenha.php" method="post">
                        <fieldset>
                            <div class="line">
                                <label>Nova senha</label>
                                <input id="novaSenha" required type="text" name="novaSenha">
                            </div>
                            <input hidden readonly id="tolken" required type="text" name="tolken" value="<?php echo $_GET['tolken'] ?>">
                                <br/>
                                <!--<a href="logar.php" class="btn">Voltar</a>-->
                                <input disabled id="botaoEnviarNovaSenha" class="btn btn-info" name="identificacao" type="submit" value="Enviar" >
                                    </fieldset>
                                    <!--<a href="#"><p class="centeredText">Esqueci minha senha</p></a>-->
                                    </form>
                                <?php endif; ?>
                                </div>
                                <div class="error centeredText">
                                    <?php
                                    if (isset($_GET['m'])) {
                                        echo $_GET['m'];
                                    }
                                    ?>
                                </div>
                                </div>
                                <div id="apoio">
                                    <h3>Apoio:</h3>
                                    <div id="uab"></div>
                                    <div id="capes"></div>
                                </div>
                                <div id="footer" >
                                    <p class="centeredText">Copyright &copy; 2012 - Desenvolvido por <a href="http://cead.unifal-mg.edu.br" target="_blank" title="Cead home page">CEAD</a></label>
                                </div>
                                <script>
                                    $("#novaSenha").keyup(function() {
                                        var a = $(this).val();
                                        console.debug(a.length);
                                        if (a.length >= 6) {
                                            $("#botaoEnviarNovaSenha").attr('disabled', false);
                                        } else {
                                            $("#botaoEnviarNovaSenha").attr('disabled', true);
                                        }
                                    });
                                </script>
                                </body>
                                </html>