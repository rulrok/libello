<?php require_once 'biblioteca/configuracoes.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title class="tituloFixo">Você não possui o Javascript habilitado</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="publico/css/bootstrap.css"/> 
        <link type="text/css" rel="stylesheet" href="publico/css/mainStyle.css" />
        <script>
            <!--
            //Caso caia na página por engano, com o javascript habilitado
            document.location.href = "<?php echo WEB_SERVER_ADDRESS; ?>";
//-->
        </script>
    </head>
    <body>
        <div class="container">
            <br/>
            <br/>
            <br/>
            <div class="hero-unit">
                <h1 class="textoCentralizado">Javascript desabilitado :(</h1>
                <br/>
                <p class="textoCentralizado">Ops... você precisa ter o javascript habilitado para poder usar o sistema.</p>
            </div>
        </div>
    </body>
</html>
