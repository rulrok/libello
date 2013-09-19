<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <!--[if !IE 7]>
        <style type="text/css">
                nav {display:table;height:100%}
        </style>
        <![endif]-->
        <link type="text/css" rel="stylesheet" href="publico/css/jquery-ui.css" />
        <link type="text/css" rel="stylesheet" href="publico/css/bootstrap.css"/> 
        <link type="text/css" rel="stylesheet" href="publico/css/mainStyle.css" />
        <link type="text/css" rel="stylesheet" href="publico/css/jquery.dataTables_themeroller.css" />
        <link type="text/css" rel="stylesheet" href="publico/css/jquery.datepick.css"/> 


        <!-- Inicialização dos principais scripts -->
        <script src="publico/js/jquery/jquery-1.9.1.js"></script>
        <script src="publico/js/jquery/jquery.ba-hashchange.js"></script>
        <script src="publico/js/mainScript.js"></script>
        <script type="text/javascript" src="publico/js/validarCampos.js"></script>
        <script src="publico/js/jquery/jquery.form.js"></script>
        <script src="publico/js/ajaxForms.js"></script> 
        <script src="publico/js/oTable.js" ></script>
        <title class="tituloFixo"><?php echo $this->titulo ?></title>
    </head>
    <body>
        <nav>
            <hr id="barra_superior" style="
                margin: 0;
                border: 2px solid #3871a6;
                background: #3871a6;
                border-left: none;
                border-right: none;
                position: fixed;
                top: 0px;
                width: 100%;
                z-index: 99999999;
                display: none;
                ">
            <header>
                <figure>
                    <map name="#logoMap">
                        <area shape="poly" coords="86,178,120,157,177,134,202,125,224,120,240,95,243,80,228,59,201,49,196,54,197,98,188,88,186,59,176,51,167,48,156,25,135,13,127,0,92,4,43,13,2,13,12,32,32,62,31,91,40,118,65,141" alt="Controle CEAD" title="Controle CEAD" />
                    </map>
                    <img class="logo" src="publico/imagens/cead.png" usemap="#logoMap"></img>
                </figure>
                <div class="headerWrap">
                    <h1>Controle CEAD <sup>(versão alpha)</sup></h1>

                </div>
                <div class="userInfoWrap">
                    <p>Logado como: <b><?php echo $this->usuario ?></b> (<?php echo $this->papel ?>)</p>
                    <div class="btn-toolbar" id="configuracoesSite">
                        <div class="centered btn-group">
                            <a id="fullscreen-on" title="Modo tela cheia" class="btn btn-small" href="javascript:void(0)" onclick="launchFullScreen(document.documentElement);"><i class="icon-fullscreen"></i></a>
                            <a id="fullscreen-off" title="Voltar ao modo normal" class="btn btn-small hide" href="javascript:void(0)" onclick="cancelFullscreen();"><i class="icon-resize-small"></i></a>
                            <a class="btn btn-small" href="#!sistema|gerenciarconta" onclick="
                                    hideSubMenu(150);
                                    $('.visited').removeClass('visited');
                                    $('.actualTool').removeClass('actualTool')"><i class="icon-cog"></i> Gerenciar Conta</a>
                            <a class="btn btn-small" href="sair.php"><i class="icon-off"></i> Sair</a>
                        </div>
                    </div>
                </div>

            </header>
            <div class="shaderFrame"></div>
            <div class="shaderFrameContent">
                <div class="shaderFrameContentWrap centered">
                    <div class="loading_background"><img src="publico/imagens/ajax-loader.gif"> Carregando...</div>
                </div>
            </div>
            <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <!--                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h3 id="myModalLabel">Modal header</h3>
                                </div>-->
                <div class="modal-body">
                    <p>One fine body…</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>
            </div>
            <hr id="menuPosition" style="margin:0;width:100%; visibility: hidden;border:none" >
            <div class="menuContainer">

                <?php echo $this->menu ?>

                <div class="popUp table" style="display: none;">
                    <div class="botao_fechar" onclick="hidePopUp();"></div>
                    <p class="popUpContent centeredText "></p>
                </div>

            </div>
            <div class="content centered">
                <center>
                </center>
                <div class="contentWrap centered">
                    <?php
                    if (isset($this->conteudo)) {
                        include $this->conteudo;
                    }
                    ?>
                </div>
            </div>
        </nav>
        <footer>
            <span class="arrow-up" onclick="showFooter();"></span>
            <div class="footerWrap">
                <span class="arrow-down" onclick="hideFooter();"></span>
                <center>
                    <div class="footerLinks" id="links-rapidos">
                        <ul><lt>Links rápidos</lt>
                            <li><a href="http://cead.unifal-mg.edu.br" target="_blank">Cead - portal</a></li>
                            <li><a href="http://virtual.unifal-mg.edu.br" target="_blank">Moodle</a></li>
                            <li><a href="http://www.unifal-mg.edu.br" target="_blank">Unifal</a></li>
                        </ul>
                    </div>
                    <div class="footerLinks" id="informacoes">
                        <ul><lt>Informações</lt>
                            <li><p>Este site é corretamente visualizado no <a href="http://www.google.com/chrome/" target="_blank">Google Chrome</a>&nbsp;&nbsp;&nbsp;ou <a href="http://www.mozilla.org/pt-BR/firefox/fx/" target="_blank">Firefox</a>.
                                    <br>
                                    <i><b>Não há garantias de funcionar com o Internet Explorer nem com o Safari.</b></i></p>
                            </li>
                        </ul>
                    </div>
                    <div class="footerLinks" id="suporte">
                        <ul><lt>Suporte</lt>
                            <li>reuel@bcc.unifal-mg.edu.br</li>
                        </ul>
                    </div>
                </center>
            </div>
        </footer>
        <!-- Inicialização de scripts importantes para outras páginas -->
        <script src="publico/js/jquery/jquery-ui.js"></script>
        <script src="publico/js/jquery/jquery.dataTables.js"></script>
        <script src="publico/js/jquery/jquery.datepick.js"></script>
        <script src="publico/js/jquery/jquery.datepick-pt-BR.js"></script>
        <script src="publico/js/bootstrap.js"></script> 
        <script>
                                //Configurações globais para dataTables
                                $.extend($.fn.dataTable.defaults, {
                                    "bFilter": true,
                                    "bSort": true,
                                    "aaSorting": [[1, "desc"]],
                                    "bJQueryUI": true,
                                    "sPaginationType": "full_numbers",
                                    "oLanguage": {
                                        "sUrl": "publico/js/jquery/dataTables.portugues.txt"
                                    },
                                    //Scrol horizontal
                                    "sScrollX": "100%",
                                    "sScrollXInner": "110%",
                                    "bScrollCollapse": true,
                                    // Salva o estado da tabela para ser exibida como da última vez
                                    //Um pouco de cuidado com essa opção, ela parece ter em certas
                                    //situações, efeitos negativos ao uso da datatable
                                    "bStateSave": false,
                                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
                                });
                                $.datepick.setDefaults({
                                    dateFormat: 'dd/mm/yyyy'
                                })

                                //Configura botão para tela cheia
                                $("#fullscreen-on").tooltip({trigger: 'hover', container: 'body', delay: {show: 50, hide: 0}});
                                $("#fullscreen-off").tooltip({trigger: 'hover', container: 'body', delay: {show: 50, hide: 0}});
        </script>
    </body>
</html>
