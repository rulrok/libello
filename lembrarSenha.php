<!DOCTYPE html">
<html>
    <head>
        <title class="tituloFixo">Lembrar senha</title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <!-- ESTILOS -->
        <link rel='stylesheet' href='publico/css/bootstrap.css' />
        <link rel='stylesheet' href='publico/css/mainStyle.css' />  
        <link rel='stylesheet' href='publico/css/login.css' />

        <!-- SCRIPTS -->
        <script src="publico/js/jquery/jquery-1.9.1.js"></script>
        <script src="publico/js/jquery/jquery.form.js"></script>
        <script src="publico/js/ajaxForms.js"></script>
        <script src="publico/js/mainScript.js"></script>

    </head>
    <body>
        <?php
        require_once './biblioteca/configuracoes.php';
        ?>
        <div id="login" class="centralizado">
            <h1 class="textoCentralizado"><?php echo APP_NAME; ?></h1>
            <h2 class="textoCentralizado">Alterar senha</h2>
            <div id="logo_esquerda_paginas_iniciais"></div>
            <div id="logo_direita_paginas_iniciais"></div>
            <div id="loginArea">
                <?php if (!filter_has_var(INPUT_GET, 'tolken')): ?>
                    <form class="tabela centralizado" id="ajaxForm" name="identificacao" action="./biblioteca/seguranca/lembrarSenha.php" method="post">
                        <fieldset>
                            <div class="line">
                                <label for="email">Email</label>
                                <input required autofocus type="text" id="email" name="email">
                            </div>
                            <br/>
                            <a href="logar.php" class="btn btn-mini"><i class='icon-arrow-left'></i> Voltar</a>
                            <button class="btn btn-info btn-right" name="identificacao" type="submit">Enviar</button>
                        </fieldset>
                    </form>
                <?php else: ?>

                    <form class="tabela centralizado" id="ajaxForm" name="identificacao" action="./biblioteca/seguranca/lembrarSenha.php" method="post" >
                        <fieldset>
                            <div class="line">
                                <label for="novaSenha">Nova senha</label>
                                <input id="novaSenha" required type="password" name="novaSenha"/>
                            </div>
                            <input hidden="true" readonly id="tolken" required type="text" name="tolken" value="<?php echo filter_input(INPUT_GET, 'tolken'); ?>"/>
                            <br/>
                            <a href="logar.php" class="btn btn-mini"><i class='icon-arrow-left'></i> Voltar</a>
                   
                            <button disabled id="botaoEnviarNovaSenha" class="btn btn-info" name="identificacao" type="submit">Enviar</button>
                        </fieldset>
                    </form>
                <?php endif; ?>
            </div>
            <div class="error textoCentralizado" id="erroWrap">
                <?php
                if (filter_has_var(INPUT_GET, 'm')) {
                    echo filter_input(INPUT_GET, 'm');
                }
                ?>
            </div>
        </div>
        <?php require_once 'apoio.php'; ?>
        <?php require_once 'footer.php'; ?>
        <script>
            formularioAjax("ajaxForm", "#erroWrap");
            $("#novaSenha").keyup(function() {
                var a = $(this).val();
                if (a.length >= 6) {
                    $("#botaoEnviarNovaSenha").prop('disabled', false);
                } else {
                    $("#botaoEnviarNovaSenha").prop('disabled', true);
                }
            });
        </script>
    </body>
</html>