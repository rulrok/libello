<!DOCTYPE html>
<html>
    <head>
        <!-- META TAGS -->

        <meta charset="UTF-8"/>
        <meta name="description" content="Ferramenta para controle interno do CEAD">
        <meta name="keywords" content="cead, gerenciamento">
        <meta name="robots" content="noindex, nofollow">
        <meta name="copyright" content="CEAD 2012 - 2014">
        <meta name="language" content="PT">
        <meta name="distribution" content="local">
        <meta name="rating" content="general">

        <!-- FIM META TAGS -->

        <!-- ESTILOS -->

        <link type="text/css" rel="stylesheet" href="publico/css/jquery-ui.css" />
        <link type="text/css" rel="stylesheet" href="publico/css/bootstrap.css"/> 
        <link type="text/css" rel="stylesheet" href="publico/css/bootstrap-responsive.css"/> 
        <link type="text/css" rel="stylesheet" href="publico/css/mainStyle.css" />
        <link type="text/css" rel="stylesheet" href="publico/css/jquery.dataTables_themeroller.css" />
        <link type="text/css" rel="stylesheet" href="publico/css/jquery.datepick.css"/> 
        <link type="text/css" rel="stylesheet" href="publico/css/jquery.chosen.css"/> 
        <link type="text/css" rel="stylesheet" href="publico/css/jquery.fancybox.css"/> 
        <link type="text/css" rel="stylesheet" href="publico/css/jquery.fancybox-buttons.css"/> 
        <link type="text/css" rel="stylesheet" href="publico/css/jquery.jstree.css"/> 
        <link type="text/css" rel="stylesheet" media="screen" href="publico/css/browser-detection.css" />
        <link type="text/css" rel="stylesheet" media="screen" href="publico/css/jquery-ui-timepicker-addon.css" />

        <!--[if !IE 7]>
        <style type="text/css">
                nav {display:table;height:100%}
        </style>
        <![endif]-->
        <!-- Fim ESTILOS -->

        <noscript>
        <style>
            #telaCarregando {
                display: none;
            }
        </style>
        </noscript>
    <div id="telaCarregando"><span>Carregando...</span></div>
    <!-- PRE SCRIPTS -->
        <!--<script src="http://ie.microsoft.com/testdrive/HTML5/CompatInspector/inspector.js"></script>-->
        <!--<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>-->

    <script src="publico/js/jquery/jquery-1.9.1.js"></script>
    <script src="publico/js/browser-detection.js" ></script>
    <script src="publico/js/jquery/jquery.ba-hashchange.js"></script>
    <script src="publico/js/jquery/jquery.form.js"></script>
    <script src="publico/js/jquery/jquery.chosen.js"></script>
    <script src="publico/js/mainScript.js"></script>
    <script src="publico/js/validarCampos.js"></script>
    <script src="publico/js/ajaxForms.js"></script>
    <script src="publico/js/debug.js"></script>
    <script>
        window.onbeforeunload = function(e) {
            if (document.paginaAlterada) {
                e = e || window.event;

                var msg = "Modificações não salvas. Continuar?";

                // For IE and Firefox prior to version 4
                if (e) {
                    e.returnValue = msg;
                }

                // For Safari
                return msg;
            }
        };
    </script>

    <!-- FIM PRE SCRIPTS -->

    <link rel="icon" type="image/png" href="publico/imagens/logotipo_header.png" />

    <title class="tituloFixo"><?php echo $this->titulo ?></title>
</head>
<body>
    <div id="frameConteudo">
        <hr id="barraSuperior">
        <header>
            <figure>
                <map name="#logoMap">
                    <area shape="poly" coords="86,178,120,157,177,134,202,125,224,120,240,95,243,80,228,59,201,49,196,54,197,98,188,88,186,59,176,51,167,48,156,25,135,13,127,0,92,4,43,13,2,13,12,32,32,62,31,91,40,118,65,141" alt="<?php echo $this->nomeAplicativo; ?>" title="<?php echo $this->nomeAplicativo; ?>" />
                </map>
                <img class="logo" src="publico/imagens/logotipo_header.png" usemap="#logoMap">
            </figure>
            <div class="headerWrap">

                <p class="centralizado"><?php echo $this->nomeAplicativo; ?><sup>(versão <?php echo APP_VERSION; ?>)</sup></p>
                <?php
                if ($this->administrador && $this->temErros) :
                    ?>
                    <div id="avisos" class="centralizado alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php
                        echo $this->erros;
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="userInfoWrap">
                <p>Logado como: <b id='nomeusuarioHeader'><?php echo $this->nomeUsuario ?></b> (<?php echo $this->papel ?>)</p>
                <div class="btn-toolbar" id="configuracoesSite">
                    <div id="botoesSuperiores" class="centralizado btn-group">


                        <a class="btn btn-small" href="#!sistema|gerenciarconta" onclick="
                                if (!document.paginaAlterada) {
                                    hideSubMenu(150);
                                    $('.visited').removeClass('visited');
                                    $('.actualTool').removeClass('actualTool');
                                }"><i class="icon-cog"></i> Gerenciar Conta</a>

                        <?php // if ($this->administrador):  ?>
                                <!--<a class="btn btn-small" href="#!sistema|administracao"><i class="icon-fire"></i> Administração</a>-->
                        <?php // endif;  ?>
                        <a class="btn btn-small" href="caixaProcessos.php"><i class="icon-tasks"></i> Processos</a>
                        <a class="btn btn-small" href="sair.php"><i class="icon-off"></i> Sair</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Conteúdos auxiliares, como modais e etc -->
        <div class="shaderFrame"></div>
        <div class="shaderFrameContent">
            <div class="shaderFrameContentWrap centralizado">
                <div class="loading_background">
                    <img src="publico/imagens/ajax-loader.gif"> Carregando...
                </div>
            </div>
        </div>
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <!--                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h3 id="myModalLabel">Modal header</h3>
                            </div>-->
            <div class="modal-body">
                <!-- CORPO -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Fechar</button>
            </div>
        </div>

        <div class="popUp tabela" style="display: none;">
            <div class="botao_fechar" onclick="hidePopUp();"></div>
            <p class="popUpContent textoCentralizado "></p>
        </div>

        <!-- Fim dos conteúdos auxiliares -->

        <hr id="menuPosition" >
        <nav>
            <div class="menuContainer">

                <?php echo $this->menu ?>



                <div id="esconderHeader"></div>

            </div>
        </nav>
        <div class="content centralizado container">

            <div class="contentWrap centralizado">
                <?php
                if (isset($this->conteudo)) {
                    include $this->conteudo;
                }
                ?>
            </div>
        </div>
    </div>
    <footer>
        <span class="arrow-up" onclick="showFooter();"></span>
        <div class="footerWrap">
            <span class="arrow-down" onclick="hideFooter();"></span>
            <center>
                <nav>
                    <div class="footerLinks" id="links-rapidos">
                        <ul><lt>Links rápidos</lt>
                            <li><a href="http://cead.unifal-mg.edu.br" target="_blank">Cead - portal</a></li>
                            <li><a href="http://virtual.unifal-mg.edu.br" target="_blank">Moodle</a></li>
                            <li><a href="http://www.unifal-mg.edu.br" target="_blank">Unifal</a></li>
                        </ul>
                    </div>
                    <div class="footerLinks" id="informacoes">
                        <ul><lt>Informações</lt>
                            <li><p>Este site é corretamente visualizado no <a href="http://www.google.com/chrome/" target="_blank">Google Chrome</a>, <a href="http://www.mozilla.org/pt-BR/firefox/fx/" target="_blank">Firefox</a> ou <a href="http://www.opera.com/download" target="_blank">Opera</a>.
                                    <br>
                                    <i><b>Não há garantias de funcionar com o Internet Explorer nem com o Safari.</b></i></p>
                            </li>
                        </ul>
                    </div>
                    <div class="footerLinks" id="suporte">
                        <ul><lt>Suporte</lt>
                            <li>reuel@bcc.unifal-mg.edu.br</li>
                            <li>a12033@bcc.unifal-mg.edu.br</li>
                        </ul>
                    </div>
                </nav>
            </center>
        </div>
    </footer>
    <!-- POS SCRIPTS -->
    <script src="publico/js/jquery/jquery-ui.js"></script>
    <script src="publico/js/jquery/jquery.dataTables.js"></script>
    <script src="publico/js/jquery/jquery.datepick.js"></script>
    <script src="publico/js/jquery/jquery.datepick-pt-BR.js"></script>
    <script src='publico/js/jquery/jquery-ui-timepicker-addon.js'></script> 
    <script src='publico/js/jquery/jquery-ui-sliderAccess.js'></script> 
    <!--<script src='publico/js/jquery/jquery.mask.min.js'></script>--> 
    <script src='publico/js/jquery/jquery.maskedinput.js'></script> 
    <script src='publico/js/jquery/jquery.fancybox.min.js'></script> 
    <script src='publico/js/jquery/jquery.fancybox-buttons.js'></script> 
    <script src='publico/js/jquery/jquery.mousewheel-3.0.6.min.js'></script> 
    <script src='publico/js/jquery/jquery.jstree.js'></script> 
    <script src="publico/js/oTable.js" ></script>
    <script src="publico/js/bootstrap/bootstrap.js"></script> 
    <script src="publico/js/require.js"></script> 
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
                    "bStateSave": true,
                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
                });
                $.datepick.setDefaults({
                    dateFormat: 'dd/mm/yyyy'
                });
                $.datepick.setDefaults($.datepick.regional['pt-BR']);
                $.datepicker.regional['pt-BR'] = {
                    closeText: 'Fechar',
                    prevText: 'Anterior',
                    nextText: 'Próximo',
                    currentText: 'Atual',
                    monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                        'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
                        'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                    dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
                    dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
                    weekHeader: 'Semana',
                    dateFormat: 'dd/mm/yy',
                    firstDay: 1,
                    isRTL: false,
                    showMonthAfterYear: true,
                    yearSuffix: ''
                };
                $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

                $.timepicker.regional['pt-BR'] = {
                    timeOnlyTitle: 'Apenas tempo',
                    timeText: 'Tempo',
                    hourText: 'Hora',
                    minuteText: 'Minuto',
                    secondText: 'Segundo',
                    millisecText: 'Milisegundo',
                    timezoneText: 'Região',
                    currentText: 'Agora',
                    closeText: 'OK',
                    timeFormat: 'HH:mm',
                    amNames: ['AM', 'A'],
                    pmNames: ['PM', 'P'],
                    isRTL: false
                };
                $.timepicker.setDefaults($.timepicker.regional['pt-BR']);

                //Configura pequena função para criar limiter em textareas
                (function($) {
                    $.fn.extend({
                        limiter: function(limit, elem) {
                            $(this).on("keyup focus", function() {
                                setCount(this, elem);
                            });
                            function setCount(src, elem) {
                                var chars = src.value.length;
                                if (chars > limit) {
                                    src.value = src.value.substr(0, limit);
                                    chars = limit;
                                }
                                elem.html(limit - chars);
                            }
                            setCount($(this)[0], elem);
                        }
                    });
                })(jQuery);
                //Configura botão para tela cheia
//                                $("#fullscreen-toggle").tooltip({trigger: 'hover', container: 'body', delay: {show: 50, hide: 0}});
//                                $("#fullscreen-off").tooltip({trigger: 'hover', container: 'body', delay: {show: 50, hide: 0}});
                if (canToggleFullScreen()) {
                    $("#botoesSuperiores").children(":first-child").before('<a id="fullscreen-toggle" title="Modo tela cheia" class="btn btn-small" href="javascript:void(0)" onclick="toggleFullScreen();"><i class="icon-fullscreen"></i></a>');
                }
                setTimeout(function() {
                    $("#telaCarregando").fadeOut(150);
                }, 150);
    </script>

    <!-- FIM POS SCRIPTS -->
</body>
</html>
