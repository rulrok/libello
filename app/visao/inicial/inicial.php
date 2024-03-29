<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title><?php echo $this->titulo ?></title>

        <!-- META TAGS -->
        <meta charset="UTF-8">
        <meta name="description" content="Ferramenta para controle interno do CEAD">
        <meta name="keywords" content="cead, gerenciamento">
        <meta name="robots" content="noindex, nofollow">
        <meta name="copyright" content="CEAD 2012 - 2014">
        <meta name="language" content="PT">
        <meta name="distribution" content="local">
        <meta name="rating" content="general">
        <!-- FIM META TAGS -->

        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">

        <!-- ESTILOS -->
        <link type="text/css" rel="stylesheet" href="publico/css/jquery-ui.css" />
        <link type="text/css" rel="stylesheet" href="publico/css/bootstrap.css"/> 
        <link type="text/css" rel="stylesheet" href="publico/css/bootstrap-responsive.css"/>
        <link type="text/css" rel="stylesheet" href="publico/css/bootstrap-datepicker.css"/>
        <link type="text/css" rel="stylesheet" href="publico/css/mainStyle.css" />
        <link type="text/css" rel="stylesheet" href="publico/css/menu.css" />
        <link type="text/css" rel="stylesheet" href="publico/css/jquery.dataTables_themeroller.css" />
        <link type="text/css" rel="stylesheet" href="publico/css/jquery.chosen.css"/>
        <link type="text/css" rel="stylesheet" href="publico/css/jquery.jstree.css"/> 
        <link type="text/css" rel="stylesheet" href="publico/css/jquery.toastmessage.css"/> 
        <link type="text/css" rel="stylesheet" media="screen" href="publico/css/browser-detection.css" />
        <link type="text/css" rel="stylesheet" href="publico/css/thumbnailgrid/component.css"/> 
        <link type="text/css" rel="stylesheet" href="publico/css/picbox/picbox.css"/>

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
        <!-- PRE SCRIPTS -->
    <!--        <script src="http://ie.microsoft.com/testdrive/HTML5/CompatInspector/inspector.js"></script>
            <script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>-->
        <script>
            ocorreuExcecaoJS = false;
            //Utilizado para capturar exceções globalmente.
            //Quando a variável 'ocorreuExcecaoJS' é verdadeira, ao abrir qualquer nova
            //página em seguida, a página no navegador será recarregada para que os scripts
            //delas possam ser executados
            window.onerror = function (msg, url, linenumber) {
                ocorreuExcecaoJS = true;
//                alert("Um erro ocorreu no aplicativo e a página pode não ser exibida corretamente.\nTente recarregar a sua página.\nPersistindo o erro, entre em contato com suporte@bi.com.br");
                console.log("Exceção ocorrida na página " + url);
                console.log(linenumber + ": " + msg);
                return false;
            };

        </script>
        <!-- jQuery Plugin -->
        <script src="publico/js/jquery/jquery-1.9.1.js"></script>
        <!-- Outros scripts -->
        <script src="publico/js/browser-detection.js" ></script>
        <script src="publico/js/jquery/jquery.ba-hashchange.js"></script>
        <script src="publico/js/jquery/jquery.form.js"></script>
        <script src="publico/js/jquery/jquery.chosen.js"></script>
        <script src="publico/js/jquery/jquery.center.js"></script>
        <script src="publico/js/mensagens.js"></script>
        <script src="publico/js/mainScript.js"></script>
        <script src="publico/js/validarCampos.js"></script>
        <script src="publico/js/ajaxForms.js"></script>
        <script src="publico/js/debug.js"></script>
        <script>
            window.onbeforeunload = function (e) {
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
    </head>
    <body>
        <div id="telaCarregando"><span>Carregando...</span></div>
        <div id="frameConteudo"> <!-- DIV principal -->
            <hr id="barraSuperior">
            <header>
                <figure>
                    <map name="#logoMap">
                        <area shape="poly" coords="86,178,120,157,177,134,202,125,224,120,240,95,243,80,228,59,201,49,196,54,197,98,188,88,186,59,176,51,167,48,156,25,135,13,127,0,92,4,43,13,2,13,12,32,32,62,31,91,40,118,65,141" alt="<?php echo $this->nomeAplicativo; ?>" title="<?php echo $this->nomeAplicativo; ?>" />
                    </map>
                    <img class="logo" src="publico/imagens/logotipo_header.png" usemap="#logoMap">
                </figure>
                <div class="headerWrap">
                    <br/>
                    <p class="centralizado tituloFixo"><?php echo $this->nomeAplicativo; ?></p>
                    <p class="centralizado descricaoSite"><?php echo $this->descricaoAplicativo; ?></p>
                    <?php if ($this->administrador && $this->temErros) : ?>
                        <!-- Avisos e mensagens do sistema -->
                        <div id="avisos" class="centralizado alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?php
                            echo $this->erros;
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="userInfoWrap">
                    <!-- Informações sobre o usuário logado -->
                    <p>Logado como: <b id='nomeusuarioHeader'><?php echo $this->nomeUsuario ?></b> (<?php echo $this->papel ?>)</p>
                    <div class="btn-toolbar" id="configuracoesSite">
                        <div id="botoesSuperiores" class="centralizado btn-group">
                            <a id="b_gerenciarconta" class="btn btn-small" href="#!sistema|gerenciarconta">
                                <i class="icon-cog"></i> Gerenciar Conta
                            </a>
                            <?php if ($this->administrador): ?>
                                <?php if ($this->modoManutencao) : ?>
                                    <a id="desativarManutencao" class="btn btn-small" ><i class="icon-certificate"></i> Desativar manutenção</a>
                                <?php else: ?>
                                    <a id="ativarManutencao" class="btn btn-small" ><i class="icon-wrench"></i> Ativar manutenção</a>
                                <?php endif; ?>
                            <?php endif; ?>
<!--<a class="btn btn-small" href="#!processos|arvoreProcessos"><i class="icon-tasks"></i>Processos</a>-->
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
                        <img src="publico/imagens/ajax-loader.gif" alt="Carregando..."> Carregando...
                    </div>
                </div>
            </div>

            <!-- Modal Bootstrap -->
            <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Modal header</h3>
                </div>
                <div id="myModalBody" class="modal-body">
                    Corpo da Modal 
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Fechar</button>
                </div>
            </div>

            <!--            <div class="debug_div_helper">
            
                            <div class="debug_div_border">
                                <p>Debug window <small>(duplo-clique para minimizar)</small></p>
                                <div class="debug_div">
            
                                </div>
                            </div>
            
                        </div>-->

            <div class="voltar_topo hide"></div>

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
            <span class="arrow-up" onclick="exibirRodape();"></span>
            <div class="footerWrap">
                <span class="arrow-down" onclick="esconderRodape();"></span>
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
                            <ul><lt>Informação</lt>
                                <li><p>Este site é corretamente visualizado no <a href="http://www.google.com/chrome/" target="_blank">Google&nbsp;Chrome</a>, <a href="http://www.mozilla.org/pt-BR/firefox/fx/" target="_blank">Mozilla&nbsp;Firefox</a> ou <a href="http://www.opera.com/download" target="_blank">Opera</a>.
                                        <br>
                                        <i><b>Não há garantias de funcionar com o Internet&nbsp;Explorer nem com o Safari.</b></i></p>
                                </li>
                            </ul>
                        </div>
                        <div class="footerLinks" id="suporte">
                            <ul><lt>Suporte</lt>
                                <li><a target="_blank" href="mailto:<?php echo APP_SUPPORT_EMAIL; ?>"><?php echo APP_SUPPORT_EMAIL; ?></a></li>
                            </ul>
                        </div>
                    </nav>
                </center>
            </div>
            <span class="versaoRodape"><sub><small>Versão: <?php echo APP_VERSION; ?></small></sub></span>
        </footer>

        <!-- POS SCRIPTS -->
        <script src="publico/js/jquery/jquery-ui.js"></script>
        <script src='publico/js/jquery/jquery-ui-sliderAccess.js'></script> 
        <script src="publico/js/jquery/jquery.dataTables.custom.js"></script>
        <script src='publico/js/jquery/jquery.maskedinput.js'></script>
        <script src='publico/js/jquery/jquery.jstree.js'></script> 
        <script src='publico/js/jquery/jquery.toastmessage.js'></script> 
        <script src="publico/js/oTable.js" ></script>
        <script src="publico/js/bootstrap/bootstrap.js"></script> 
        <script src="publico/js/bootstrap/bootstrap-datepicker.js"></script>
        <script src="publico/js/bootstrap/bootstrap-datepicker.pt-BR.js"></script>
        <script src="publico/js/jquery/jquery.picbox.js"></script>
        <script src="publico/js/moment.js"></script>
        <script src="publico/js/require.js"></script> 
        <script src="publico/js/limiter.js"></script> 

        <script>
                    //----------------------------------------------------------------------//
                    //                          INICIALIZAÇÕES BÁSICAS                      //
                    //----------------------------------------------------------------------//
                    $(document).ready(function () {

                        $(".voltar_topo").on('click', function () {
                            $('html, body').animate({scrollTop: 0}, 'fast');
                        });

                        $(".debug_div_border").resizable({
                            handles: 'n'
                            , grid: 20
                            , minHeight: 20
                            , maxHeight: 500
//                            , alsoResize: ".debug_div"
//                            , animate: true
//                            , helper: "ui-resizable-helper"
                            , resize: function (event, ui) {
                                $(".debug_div_border").css({
                                    position: "relative !important",
                                    top: "",
                                    left: "0 !important"
                                });
                            }
                            , start: function (event, ui) {
                                $(".debug_div_border").css({
                                    position: "relative !important",
                                    top: "",
                                    left: "0 !important"
                                });
                            }
                            , stop: function (event, ui) {
                                $(".debug_div_border").css({
                                    position: "absolute",
                                    bottom: "0",
                                    top: "",
                                    left: ""
                                });
                            }
                        });
                        $(".debug_div, .debug_div_border").dblclick(function () {
                            setTimeout(
                                    function () {
                                        $(".debug_div_border").css({
                                            height: 20
                                        });
                                    }
                            , 50);
                        });

                        $("#b_gerenciarconta").on('click', function () {
                            if (!document.paginaAlterada) {
                                _esconderSubmenu(150);
                                $('.visited').removeClass('visited');
                                $('.actualTool').removeClass('actualTool');
                            }
                        })

                        $("#ativarManutencao").on('click', function () {
                            var resultado = confirm("Deseja realmente fazer isso?\nTodos os usuários serão desconectados do portal (exceto administradores).");
                            if (resultado) {
                                carregarAjax('index.php?c=sistema&a=ativarmanutencao', {
                                    recipiente: null
                                    , sucesso: function () {
                                        location.reload();
                                    }
                                });
                            }
                        });

                        $("#desativarManutencao").on('click', function () {
                            carregarAjax('index.php?c=sistema&a=desativarmanutencao', {
                                recipiente: null
                                , sucesso: function () {
                                    location.reload();
                                }
                            });
                        });

                        //Quando o endereço url for mudado na barra de endereço, ativa essa função.
                        $(window).bind('hashchange', function (e) {
                            if (document.ignorarHashChange === true) {
                                document.ignorarHashChange = false;
                                return;
                            }
                            if (document.paginaAlterada) {
                                var ignorarMudancas = confirm("Modificações não salvas. Continuar?");
                                if (!ignorarMudancas) {
                                    var antigaURL = e.originalEvent.oldURL;
                                    location.href = antigaURL;
                                    //                history.
                                    document.ignorarHashChange = true;
                                    return false;
                                }
                            }
                            try {
                                var url = location.hash;
                            } catch (ex) {
                                url = e.fragment;
                            }

                            if (url === "") {
                                url = "#!inicial|homepage";
                                history.replaceState(null, null, url); //Importante! Não apagar!
                            }

                            carregarMetalink(url);
                            $("a[href^=#]").each(function (index) {
                                if (this.confirmarDados === undefined) {
                                    this.confirmarDados = true;
                                    $(this).bind("click", _confirmarDadosNaoSalvos);
                                    $(this).bind("click", _requererPaginaAtual);
                                }
                            });
                            document.paginaAlterada = false;
                        });

                        // Since the event is only triggered when the hash changes, we need to trigger
                        // the event now, to handle the hash the page may have loaded with.
                        $(window).trigger('hashchange');

                        //Para que quando a tela redimensionar e o popup com fundo cinza estiver sendo exibido,
                        //ele seja centralizado novamente, evitando exibições estranhas
                        $(window).bind("resize", function () {
                            $(".shaderFrameContent").center();
                        });

                        //Permite que a mensagem `carregando` seja arrastada pela tela
                        $('.shaderFrameContent').draggable({cancel: ".shaderFrameContentWrap"});

                        //Comentado para que não permita o fechamento do cinza esmacido ao ser clicado!
//                        $(".shaderFrame").click(function() {
//                            $(".shaderFrame").css("visibility", "hidden").css("opacity", "0");
//                            $(".shaderFrameContent").css("visibility", "hidden").css("opacity", "0");
//                        });

                        esconderRodape();
//                        exibirRodape();

//                        $(".popUp").hide();

                        if (!String.prototype.trim) {
                            String.prototype.trim = function () {
                                return this.replace(/^\s+|\s+$/g, '');
                            };
                        }

                        //Associa uma função para todos os links do menu
                        var menus = $('.menuLink');
                        for (var i = 0; i < menus.length; i++) {
                            if (menus[i].id == "homeLink") {
                                $(menus[i]).bind("mouseup", function () {
                                    if (document.paginaAlterada) { //Fix :p
                                        return false;
                                    }
                                    $(".menuLink.visited").removeClass("visited");
                                    $(this).addClass("visited");
                                    $(".actualTool").removeClass('actualTool');
                                    $(this).addClass("actualTool");

                                    _esconderSubmenu(150);
                                    _contruirSubmenus(null);
                                });
                                continue;
                            }
                            $(menus[i]).bind("mouseup", function () {
                                var id = this.id;
                                if (!this.className.match(".*visited.*")) {
                                    $(".menuLink.visited").removeClass("visited");
                                    $(this).addClass("visited");
                                    _esconderSubmenu(0);
                                    _contruirSubmenus(this);
                                    _exibirSubmenu();
                                } else {
                                    //                if ($(".subMenu").css("opacity") == "1") {
                                    if (!$(".subMenu").hasClass("hidden")) {
                                        _esconderSubmenu();
                                    } else {
                                        _exibirSubmenu();
                                    }
                                }
                            });
                        }
                        //    };

                        //Manter o menu 'colado' no topo da página quando ela desce muito
                        $(window).bind("scroll", _acoplarMenu);

                        //----------------------------------------------------------------------//
                        //               CONFIGURAÇÕES DE COMPONENTES DE TERCEIROS              //
                        //----------------------------------------------------------------------//
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
                        //COnfigurações de idioma para MomentJS
                        moment.lang('pt_BR', {
                            months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outrubro", "Novembro", "Dezembro"],
                            monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
                            weekdays: ["Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo"],
                            weekdaysShort: ["Seg", "Ter", "Qua", "Qui", "Sex", "Sab", "Dom"],
                            weekdaysMin: ["S", "T", "Q", "Q", "S", "S", "D"],
                            longDateFormat: {
                                LT: "HH:mm",
                                L: "DD/MM/YYYY",
                                LL: "D MMMM YYYY",
                                LLL: "D MMMM YYYY LT",
                                LLLL: "dddd D MMMM YYYY LT"
                            },
                            calendar: {
                                sameDay: "[Hoje] LT",
                                nextDay: '[Amanhã] LT',
                                nextWeek: 'dddd [à] LT',
                                lastDay: '[Ontem] LT',
                                lastWeek: 'dddd [Semana passada] LT',
                                sameElse: 'L'
                            },
                            relativeTime: {
                                future: "em %s",
                                past: "%s atrás",
                                s: "agora a pouco",
                                m: "um minuto",
                                mm: "%d minutos",
                                h: "uma hora",
                                hh: "%d horas",
                                d: "um dia",
                                dd: "%d dias",
                                M: "um mês",
                                MM: "%d meses",
                                y: "um ano",
                                yy: "%d anos"
                            },
                            ordinal: function (number) {
                                return number + (number === 1 ? 'º' : '');
                            },
                            week: {
                                dow: 1, // Monday is the first day of the week.
                                doy: 4  // The week that contains Jan 4th is the first week of the year.
                            }
                        });
                        moment.lang('pt_BR');

                        //Configura o bootstrap-datepicker
                        $.fn.datepicker.defaults.autoclose = true;
                        $.fn.datepicker.defaults.beforeShowDay = $.noop;
                        $.fn.datepicker.defaults.calendarWeeks = false;
                        $.fn.datepicker.defaults.clearBtn = true;
                        $.fn.datepicker.defaults.daysOfWeekDisabled = [];
                        $.fn.datepicker.defaults.endDate = Infinity;
                        $.fn.datepicker.defaults.forceParse = true;
                        $.fn.datepicker.defaults.format = 'dd/mm/yyyy';
                        $.fn.datepicker.defaults.keyboardNavigation = false;
                        $.fn.datepicker.defaults.language = 'pt-BR';
                        $.fn.datepicker.defaults.minViewMode = 0;
                        $.fn.datepicker.defaults.multidate = false;
                        $.fn.datepicker.defaults.multidateSeparator = ';';
                        $.fn.datepicker.defaults.orientation = "auto";
                        $.fn.datepicker.defaults.rtl = false;
                        $.fn.datepicker.defaults.startDate = -Infinity;
                        $.fn.datepicker.defaults.startView = 0;
                        $.fn.datepicker.defaults.todayBtn = false;
                        $.fn.datepicker.defaults.todayHighlight = true;
                        $.fn.datepicker.defaults.weekStart = 0;

                        //Configurar botão para tela cheia
                        if (_canToggleFullScreen()) {
                            $("#botoesSuperiores").children(":first-child").before('<a id="fullscreen-toggle" title="Modo tela cheia" class="btn btn-small" href="javascript:void(0)" onclick="_toggleFullScreen();"><i class="icon-fullscreen"></i></a>');
                        }
                        setTimeout(function () {
                            $("#telaCarregando").fadeOut(150);
                        }, 150);
                    });

        </script>

        <!-- FIM POS SCRIPTS -->
    </body>
</html>
