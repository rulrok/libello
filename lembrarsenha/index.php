<?php
require_once './../biblioteca/configuracoes.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Lembrar senha</title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <link rel="icon" type="image/ico" href="../favicon.ico"/>

        <!-- FOLHAS DE ESTILO -->
        <link rel='stylesheet' href='../publico/css/bootstrap.css' />
        <link rel='stylesheet' href='../publico/css/login.css' />
        <link rel="stylesheet" media="screen" href="../publico/css/browser-detection.css" />

        <!-- SCRIPTS -->

        <script src="../publico/js/jquery/jquery-1.9.1.js"></script>
        <script src="../publico/js/jquery/jquery.form.js"></script>
        <script src="../publico/js/ajaxForms.js"></script>
        <script>
            $(document).ready(function() {
                document.paginaAlterada = false;
                formularioAjax("ajaxForm", "#erroWrap");
                $("#novaSenha").keyup(function() {
                    var a = $(this).val();
                    if (a.length >= 6) {
                        $("#botaoEnviarNovaSenha").prop('disabled', false);
                    } else {
                        $("#botaoEnviarNovaSenha").prop('disabled', true);
                    }
                });
            });
        </script>

    </head>
    <body>
        <div id="login" class=" container-fluid">
            <div class="row-fluid">
                <div style="padding-top: 35px;">
                    <div class="span6" style="padding-right: 30px;">
                        <h1 class="text-right"><?php echo APP_NAME; ?></h1>
                        <h2 class="text-right">Alterar senha</h2>
                    </div>
                    <div class="span6">
                        <?php if (!filter_has_var(INPUT_GET, 'token')): ?>
                            <form id="ajaxForm" action="./../biblioteca/seguranca/lembrarSenha.php" method="post">
                                <div class="control-group">
                                    <input required autofocus autocomplete="off" type="email" id="email" name="email" placeholder="Email">
                                </div>
                                <br/>
                                <br/>
                                <div class="control-group">
                                    <a href="<?php echo WEB_SERVER_ADDRESS; ?>logar" class="btn btn-link">Acessar conta</a>
                                    <button class="btn btn-info pull-right" name="identificacao" type="submit">Enviar</button>
                                </div>
                            </form>
                        <?php else: ?>
                            <form id="ajaxForm" action="./../biblioteca/seguranca/lembrarSenha.php" method="post" >
                                <div class="control-group">
                                    <input required autocomplete="off" id="novaSenha" type="password" name="novaSenha" placeholder="Nova senha"/>
                                </div>
                                <input hidden="true" readonly id="token" required type="text" name="token" value="<?php echo filter_input(INPUT_GET, 'token'); ?>"/>
                                <br/>
                                <br/>
                                <div class="control-group">
                                    <a href="<?php echo WEB_SERVER_ADDRESS; ?>logar" class="btn btn-link">Acessar conta</a>
                                    <button disabled id="botaoEnviarNovaSenha" class="btn btn-info pull-right" name="identificacao" type="submit">Enviar</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="error text-center" id="erroWrap">
                <?php
                if (filter_has_var(INPUT_GET, 'm')) {
                    echo filter_input(INPUT_GET, 'm');
                }
                ?>
            </div>
        </div>
    </div>
    <?php require_once '../apoio.php'; ?>
    <?php require_once '../footer.php'; ?>
</body>
</html>