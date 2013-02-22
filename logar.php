<?php
/*
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
include("includes/seguranca.php");


//Faz com que a pessoa não precise 'relogar' caso acesse a página principal.
if (isset($_SESSION['idUsuario'])) {
    header("Location: ./intermed.php");
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel='stylesheet' href='publico/css/login.css' />
        <link rel='stylesheet' href='publico/css/mainStyle.css' />  
        <title>Login</title>
    </head>
    <body>
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
                            <form id="form1" name="form1" action="includes/validalogin.php" method="post">
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
                                        <th colspan="2"><label><input type="submit" value="Entrar" /></label></th>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                    <tr align="center"><td><div id="message"></div></td></tr>
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