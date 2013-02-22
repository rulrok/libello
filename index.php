<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
require 'Includes/Mvc/CarregadorAutomatico.php';
require 'Includes/Mvc/Mvc.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
    <head>
        <meta http-equhandleiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="publico/css/mainStyle.css" >
            <script type="text/javascript" src="publico/js/jquery-1.9.1.js"></script>
            <script type="text/javascript" src="publico/js/mainScript.js"></script>
    </head>
    <body>
        <!-- <hr id="upperLimit" style="margin:0;position:fixed;width:100%;"> -->
        <header>
            <img class="logo" src="publico/images/cead.png" usemap="logoMap">
                <map name="logoMap">
                    <area shape="poly" coords="86,178,120,157,177,134,202,125,224,120,240,95,243,80,228,59,201,49,196,54,197,98,188,88,186,59,176,51,167,48,156,25,135,13,127,0,92,4,43,13,2,13,12,32,32,62,31,91,40,118,65,141," href="#" alt="" title="HomePage" />
                </map>
                <div class="headerWrap">
                    <br/>
                    <h1>Bem vindo ao controle CEAD <sup>(beta)</sup></h1>

                </div>
                <div class="userInfoWrap">
                    <p>Logado como: <b>$algum_nome</b></p>
                    <a href="#" id="gerenciarConta">Gerenciar Conta</a>&nbsp;&nbsp;&nbsp;
                    <a href="#" id="sair">sair</a>
                </div>

        </header>
        <hr id="menuPosition" style="margin:0;width:100%; visibility: hidden;border:none" >
            <div class="menuContainer">
                <div class="menu">
                    <menu>
                        <a><li class="menuLink visited" id="homeLink" class="visited">Home</li></a>
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
                <?php
                //CarregadorAutomatico::registrar();
                //Mvc::pegarInstancia()->rodar();
                ?>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis cursus lectus non tellus tristique gravida. Praesent fringilla tortor eu neque adipiscing adipiscing. Integer commodo sem urna, non tempus nunc. Nulla facilisi. Sed blandit, tortor eget eleifend varius, nisi leo tincidunt tellus, ut commodo risus ligula non erat. Nulla libero dui, dictum vel imperdiet non, placerat et sem. Aenean ut justo risus, in tristique felis. Maecenas feugiat nulla in ligula ultrices dictum. Aliquam dui ante, semper dignissim tempus et, gravida non ipsum. Vivamus venenatis mauris at elit euismod nec condimentum elit sollicitudin. Ut sed nisi tellus, a cursus urna. Cras sed tortor non nulla commodo suscipit id ac ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eleifend erat sed nisl commodo suscipit.
                </p><p>
                    Cras feugiat neque sed quam scelerisque mollis. Praesent lectus quam, commodo et ullamcorper nec, adipiscing porttitor massa. Duis euismod nisl et lacus commodo non bibendum enim dapibus. Cras tortor nisi, eleifend a interdum tincidunt, euismod et elit. Vivamus vulputate sapien id elit rhoncus placerat pretium justo consequat. Donec mattis congue libero, in euismod sem facilisis sed. Sed scelerisque, leo in consequat scelerisque, leo nibh porta enim, adipiscing tempus ligula magna a nunc. Sed placerat vehicula arcu, in adipiscing libero lacinia non. Donec tempus laoreet condimentum. Duis nunc velit, porta at consectetur vitae, eleifend pharetra nunc. Suspendisse ut velit quis nisl lacinia varius in at metus. Nullam pellentesque, ligula at molestie lacinia, eros sem tincidunt odio, et venenatis orci sapien in nisl. Mauris pharetra vestibulum odio vel hendrerit. Vestibulum euismod porta nibh, elementum bibendum sapien convallis placerat.
                </p><p>
                    Donec ac ullamcorper purus. Nulla interdum dictum eros sit amet porta. Donec quam tellus, adipiscing hendrerit lobortis eu, mollis a lorem. Sed semper pharetra nulla eu egestas. Mauris gravida congue erat eu sollicitudin. Fusce tempor mattis gravida. Duis nisi arcu, imperdiet ac sollicitudin et, mollis a velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer gravida tincidunt dictum.
                </p><p>
                    Ut tempus aliquet nisi id scelerisque. Ut tempus dignissim leo a tincidunt. Ut at velit a purus consequat condimentum sit amet ac metus. Quisque pulvinar accumsan facilisis. Fusce a velit nulla, eu fermentum mi. Donec pharetra ligula sed eros facilisis quis consectetur lacus elementum. Maecenas id scelerisque sapien. Sed tortor lacus, accumsan sit amet laoreet sit amet, mattis non magna. Aliquam ut hendrerit neque. Vivamus in eros eget elit vulputate vehicula. Nulla bibendum suscipit nulla eget aliquet. Nunc molestie nunc ac orci mollis a aliquam massa hendrerit. Sed a arcu nulla. Nam massa orci, malesuada at pulvinar eu, feugiat sit amet mi.
                </p><p>
                    Aliquam consectetur gravida lorem, non congue odio aliquet non. Nullam lacinia felis nec est semper iaculis. Duis eu risus leo. Sed interdum consectetur elementum. Mauris nisl neque, consectetur vel posuere id, posuere nec ligula. Vestibulum vel lectus nibh. Sed gravida, lacus id euismod suscipit, urna felis elementum massa, eu dapibus quam arcu eu nibh. Ut et massa ante. Mauris malesuada, orci vitae bibendum egestas, dolor magna facilisis nisl, in volutpat dolor massa ut dolor.
                </p>

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
