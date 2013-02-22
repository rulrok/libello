<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <link type="text/css" rel="stylesheet" href="publico/css/mainStyle.css" />
        <script type="text/javascript" src="publico/js/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="publico/js/mainScript.js"></script>
        <title><?php echo $this->titulo ?></title>
    </head>
    <body>
        <!-- <hr id="upperLimit" style="margin:0;position:fixed;width:100%;"> -->
        <header>
            <figure>
                <img class="logo" src="publico/images/cead.png" usemap="logoMap">
            </figure>
            <map name="logoMap">
                <area shape="poly" coords="86,178,120,157,177,134,202,125,224,120,240,95,243,80,228,59,201,49,196,54,197,98,188,88,186,59,176,51,167,48,156,25,135,13,127,0,92,4,43,13,2,13,12,32,32,62,31,91,40,118,65,141," href="#" alt="" title="HomePage" />
            </map>
            <div class="headerWrap">
                <br/>
                <h1>Bem vindo ao controle CEAD <sup>(beta)</sup></h1>

            </div>
            <div class="userInfoWrap">
                <p>Logado como: <b>$algum_nome</b></p>
                <a href="index.php?c=sistema&a=gerenciar" id="gerenciarConta">Gerenciar Conta</a>
                <a href="index.php?c=sistema&a=sair" id="sair">Sair</a>
            </div>

        </header>
        <hr id="menuPosition" style="margin:0;width:100%; visibility: hidden;border:none" >
            <div class="menuContainer">
                <div class="menu">
                    <menu>
                        <!-- <a><li class="menuLink visited" id="homeLink" class="visited">Home</li></a> -->
                        <a><li class="menuLink" id="usuariosLink">Controle de usuarios</li></a>
                        <a><li class="menuLink" id="cursosLink">Cursos e polos</li></a>
                        <a><li class="menuLink" id="livrosLink">Livros</li></a>
                        <a><li class="menuLink" id="equipamentosLink">Equipamentos</li></a>
                        <a><li class="menuLink" id="documentosLink">Documentos</li></a>
                        <a><li class="menuLink" id="viagensLink">Viagens</li></a>
                    </menu>
                </div>
                <div class="subMenu">
                    <menu>
                        <!-- o código desse trecho é gerado automaticamente -->
                    </menu>
                </div>
            </div>
            <div class="content">
                <div class="contentWrap">
                    <!-- o conteúdo é pego pelo ajax -->
                </div>
            </div>
            <footer>
                <div class="footerWrap">
                    <center>
                        <div class="footerLinks">
                            <ul><lt>Links rapidos</lt>
                                <li><a href="#">Cead - portal</a></li>
                                <li><a href="#">Moodle</a></li>
                                <li><a href="#">Unifal</a></li>
                            </ul>
                        </div>
                        <div class="footerLinks">
                            <ul><lt>Informacoes</lt>
                                <li><p>Este é o sistema de controle do CEAD.
                                        Nele estão disponíveis ferramentas que irão auxiliar na gestão do CEAD
                                    </p>
                                </li>
                                <!--
                                <li>
                                    <p>Por se tratar de uma ferramenta em fase beta, alguns erros podem ser
                                        encontrados. Por favor, entre em contato se você estiver tendo qualquer
                                        dificuldade de uso por funcionamento inadequado do sistema.</p>
                                </li>
                                -->
                            </ul>
                        </div>
                        <div class="footerLinks">
                            <ul><lt>Suporte</lt>
                                <li>reuel@bcc.unifal-mg.edu.br</li>
                            </ul>
                        </div>
                    </center>
                </div>
            </footer>
    </body>
</html>
