<!DOCTYPE html">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel='stylesheet' href='publico/css/mainStyle.css' />  
        <link rel='stylesheet' href='publico/css/login.css' />
        <title>Autenticação</title>
    </head>
    <body>
        <?php
        session_start();
        if ($_SESSION['iniciada'] === true && $_SESSION['autenticado'] === TRUE) {
            header("Location: index.php");
        } else {
            $_SESSION['autenticado'] = false;
        }
        ?>
        <div id="login" >
            <table width="520" border="0" style="position: relative; margin: 0 auto;">
                <thead>
                    <tr align="center">
                        <td colspan="3"><h1>Sistema de Controle CEAD</h1></td>
                        <tr align="center">
                            </thead>
                            <td width="140" rowspan="2" align="center"><div id="unifal" style="margin: 0"></div></td>
                            <td width="220"><h2 style="text-align: center;"><p>Login de Acesso</p></h2></td>
                            <td width="160" rowspan="2" align="right"><div id="cead" style="margin: 0"></div></td></tr>
                    </tr>
                    <tr>
                        <td align="center">
                            <form name="identificacao" action="./biblioteca/seguranca/seguranca.php" method="post">
                                <table width="200" border="0" align="center">
                                    <tr>
                                        <td><div style="font-size: 14px;text-align: right;">Usuário: </div></td>
                                        <td><label>
                                                <input type="text" name="login"/>
                                            </label></td>
                                    </tr>
                                    <tr>
                                        <td><div style="font-size: 14px;text-align: right;">Senha: </div></td>
                                        <td><label>
                                                <input type="password" name="senha" />
                                            </label></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2"><label><input name="identificacao" type="submit" value="Entrar" /></label></th>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                    <tr><td colspan="3" class="centered centeredText">
                            <div class="error">
                                <?php
                                if (isset($_GET['m'])) {
                                    echo $_GET['m'];
                                }
                                ?>
                            </div></td></tr>
            </table>
        </div>
        <div id="apoio">
            <h3>Apoio:</h3>
            <div id="uab"></div>
            <div id="capes"></div>
        </div>
        <div id="footer" >
            <center><p>Copyright &copy; 2012 - Desenvolvido por <a href="http://cead.unifal-mg.edu.br" target="_blank" title="Cead home page">CEAD</a></p></center>
        </div>
    </body>
</html>