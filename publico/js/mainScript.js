//----------------------------------------------------------------------//
//                          VARIÁVEIS                                   //
//----------------------------------------------------------------------//

/**
 * Auxilia o script para saber quando deve fixar ou não o menu ao topo da página
 * 
 * @type Boolean
 */
window.menuAcoplado = false;
/**
 * Inicialmente a página está codificada para exibir ele, e o script para esconde-lo é executado
 * na primeira renderização da página, por tanto, window.rodapeEscondido deve estar inicialmente
 * configurado como false.
 * @type Boolean
 */
window.rodapeEscondido = false;
/**
 * Usado para quando se muda de página para não sair por engano e perder dados.
 * @type Boolean
 */
document.paginaAlterada = false;
/**
 * Permite trocar o endereço URL da barra de endereço sem forçar o carregamento da página
 * @type Boolean
 */
document.ignorarHashChange = false;

//----------------------------------------------------------------------//
//                          FUNÇÕES                                     //
//----------------------------------------------------------------------//

/**
 * Retorna um código identificando o S.O. Possíveis retornos:
 * "Windows", "MacOS", "UNIX", "Linux" ou "Unknown".
 * 
 * @returns {String}
 */
function obterNomeNavegador() {

    var OSName = "Unknown";
    if (navigator.appVersion.indexOf("Win") != -1)
        OSName = "Windows";
    if (navigator.appVersion.indexOf("Mac") != -1)
        OSName = "MacOS";
    if (navigator.appVersion.indexOf("X11") != -1)
        OSName = "UNIX";
    if (navigator.appVersion.indexOf("Linux") != -1)
        OSName = "Linux";

    return OSName;
}

/**
 * Função auxiliar, executada quando um link é clicado, para antes que uma hash
 * seja mudada no endereço da url, caso um formulário esteja sendo editado,
 * a funcão vai impedir isso, perguntando se o usuário deseja realmente sair
 * da página atual ainda não salva.
 * 
 * @author Reuel
 * 
 * @param {tipo} evt
 * @returns {undefined}
 */
function _confirmarDadosNaoSalvos(evt) {
    if (document.paginaAlterada) {
        var ignorarMudancas = confirm("Modificações não salvas. Continuar?");
        if (!ignorarMudancas) {
            evt.preventDefault();
            return false;
        } else {
            document.paginaAlterada = false;
            return true;
        }
    }
}

/**
 * Função auxiliar para quando clica-se em um link que é a página atual.
 * Quando isso ocorre, o event hashchange não é disparado e a página não é carregada.
 * 
 * @param {tipo} evt
 * @returns {undefined}
 */
function _requererPaginaAtual(evt) {
    var index = this.href.lastIndexOf("#")
    var hash = this.href.substring(index);
    if (location.hash == hash) {
        if (!document.paginaAlterada) {
            carregarMetalink(hash);
        }

    }
}

/**
 * Função para 'colar' o menu quando a página descer. Perceba que a função é otimizada.
 * Ela não fica refazendo operações desnecessárias, como atualizar o css do menu
 * sem necessidade. Em suma, ela detecta quando de fato o menu deve ser desprendido
 * e quando deve ser colado superiormente, através da variável window.menuAcoplado.
 * 
 * @author Reuel
 * 
 * @returns {undefined}
 */
function _acoplarMenu() {
    var menu = $("#menuPosition");
    var menuPosition = menu.position().top;
    var windowPosition = $(window).scrollTop();
    if (!window.menuAcoplado && windowPosition >= menuPosition) {
        window.menuAcoplado = true;
        /*  MENU FIXADO  */
        _esconderSubmenu(400);
        $(".voltar_topo").show(500);
        $("#barra_superior").show(800);
        var divMenu = $(".menuContainer");
        var menuHeight = divMenu.height();
        divMenu.addClass("fixedMenu");
        divMenu.css('position', 'fixed');
        divMenu.css('top', '0px');
        divMenu.css('width', '100%');
        var divContent = $(".content");
        divContent.css('padding-top', menuHeight + 'px');

        $(".menuContainer").hover(function () {
            _exibirSubmenu(100)
        }, function () {
            _esconderSubmenu(20)
        });
        $(".subMenu").mouseenter(function () {
            $(".menuContainer").css('background', 'url("publico/imagens/backgroundMenu.png")')
        })
    } else if (window.menuAcoplado && windowPosition < menuPosition) {
        window.menuAcoplado = false;
        $(".voltar_topo").hide(500);
        $("#barra_superior").hide(500);
        _exibirSubmenu();
        /*  MENU NORMAL  */
        var divMenu = $(".menuContainer");
        divMenu.removeClass("fixedMenu");
        divMenu.css('position', 'relative');
        divMenu.css('top', '0px');
        var divContent = $(".content");
        divContent.css('padding-top', '0px');

        $(".menuContainer").unbind("mouseenter mouseleave")
    }
}

/**
 * Recebe um meta-link e faz a sua requisição via Ajax. A maior importância desse método é para após
 * a página ser carregada, 
 * 
 * Um meta-link possui o seguinte formato:
 * <code>#![nomeControlador]|[nomeAcao](lista opcional de parâmetros GET)</code>
 * 
 * @param {string} metalink
 * @returns {Boolean}
 */
function carregarMetalink(metalink) {

    if (metalink === undefined || metalink === null | !/^#![a-z]+\|[a-z]+((\&[a-zA-Z]+=[a-z0-9]*)+)?/.test(metalink)) {
        return false;
    }
    var url = "index.php?c=<c>&a=<a>";


    var novolink = metalink.replace("#!", "");
    novolink = novolink.split("|");

    //Importante para não causar um loop infinito na página.
    if (novolink[1] === "inicial") {
        novolink[1] = "404";
    }
    url = url.replace("<c>", novolink[0]);
    url = url.replace("<a>", novolink[1]);

    carregarAjax(url);

    if (metalink !== location.hash) {
        history.pushState(null, null, metalink);
    }
    var menu = novolink[0];
    if (menu === "inicial" || menu === undefined) {
        menu = "home";
    }
    var ferramentaAtual = $(".actualTool").prop("id");
    try {
        if (ferramentaAtual.lastIndexOf(menu) === -1) {
            $(".actualTool").removeClass("actualTool");
            $(".visited").removeClass("visited");
            $(".menuLink[id^=" + menu + "]").addClass("actualTool");
            $(".menuLink[id^=" + menu + "]").addClass("visited");
            var menuObj = new Object();
            menuObj.id = menu + "Link";
            _contruirSubmenus(menuObj);
            _exibirSubmenu();
        }
    } catch (ex) {
        $(".menuLink[id^=" + menu + "]").addClass("actualTool");
        $(".menuLink[id^=" + menu + "]").addClass("visited");
        var menuObj = new Object();
        menuObj.id = menu + "Link";
        _contruirSubmenus(menuObj);
        _exibirSubmenu();
    }
}

/**
 * Bloqueia a tela com uma pequena janela de 'Carregando...' e um fundo preto transparente.
 * 
 * @returns {undefined}
 */
function exibirMensagemCarregando() {
    $(".loading_background").css("display", "initial");
    $(".shaderFrame").css("visibility", "visible").animate({opacity: "0.5"}, 150);
    $(".shaderFrameContent").css("visibility", "visible").animate({opacity: "1"}, 350);
    $(".shaderFrameContent").center();
}

/**
 * Desfaz a ação do método <code>exibirMensagemCarregando</code>
 * @returns {undefined}
 */
function esconderMensagemCarregando() {
    $(".loading_background").css("display", "none");
    $(".shaderFrame").css("visibility", "hidden").css("opacity", "0");
    $(".shaderFrameContent").css("visibility", "hidden").css("opacity", "0");
}
/**
 * Função para auxiliar chamadas Ajax.
 * Faz a chamada do link via Ajax usando o método GET. A resposta da página invocada
 * pode ser inserida em qualquer elemento através da opção <code>recipiente</code>. Por padrão elas são
 * carregadas
 * 
 * @param {string} url Endereço a ser invocado
 * @param {PlainObject} opcoes 
 * <dl>
 * <dt>{string} <b>recipiente</b></dt><dd>Qualquer string que possa ser usada como um seletor jQuery, como por exemplo '.classe' ou '#id'.<br/>Caso <code>null</code> seja passado, a resposta não será colocada em lugar algum.<br/>Caso <code>undefined</code>, a resposta será colocada em ".contentWrap".</dd>
 * <dt>{boolean} <b>async</b></dt><dd>Especifíca se o carregamento deve ser assíncrono ou não. Por padrão, essa opção é falsa.</dd>
 * <dt>{boolean} <b>ignorarMudancas</b></dt><dd> Faz a chamada sem perguntar se o usuário deseja sair, caso tenho feito alguma alteração no documento. Falso por padrão.</dd>
 * <dt>{function} <b>sucesso</b></dt><dd>Função para ser executada caso a operação Ajax seja bem sucedida. Ela será a última função a ser executada antes de retornar o método (e após a resposta ter sido adicionada ao recipiente, caso algum tenha sido escolhido).</dd>
 * <dt>{function} <b>fnErro</b></dt><dd> Função para ser executada caso a operação Ajax seja mal sucedida. </dd>
 * </dl>
 * @returns {undefined}
 */
function carregarAjax(url, opcoes) {

    var opcoes = opcoes || {};
    var funcaoVazia = function () {
    };

    var recipiente = opcoes.recipiente ? recipiente = opcoes.recipiente : (opcoes.recipiente === undefined ? ".contentWrap" : null);
    var async = opcoes.async || true;
    var ignorarMudancas = opcoes.ignorarMudancas || false;
    var fnSucesso = opcoes.sucesso || funcaoVazia;
    var fnErro = opcoes.erro || funcaoVazia;

    /**
     * Trata todos os campos obrigatórios de uma página recém carregada.
     * Com exceção dos campos da classe <code>.ignorar</code>, todos os demais
     * (caso existam) modificarão a variável <code>document.paginaAlterada</code>
     * indicando que dados foram modificados no formulário desde a sua chamada.
     * Com isso, caso o usuário tente acessar outra página, a página atual irá
     * pergutar se ele realmente deseja fazer isso, perdendo todos os dados ainda
     * não salvos.
     * 
     * @returns {undefined}
     */
    function _tratarCamposEditaveis() {
        var camposAlteraveis = $("input, select, textarea").not('.ignorar').not("[hidden]").not("[readonly]");
        $(camposAlteraveis).bind("keyup", function (param) {
            if (param.keyCode != 13)
                document.paginaAlterada = true;
        });
        $(camposAlteraveis).bind("change", function (param) {
            if (param.keyCode != 13)
                document.paginaAlterada = true;
        });
        var camposData = $(".campoData").not(".ignorar");

        $(camposData).on("mousedown", function (e) {
            $(camposData).on("mouseup", function (param) {
                setTimeout(function () {
                    if (param.keyCode != 13)
                        document.paginaAlterada = true;
                }, 300);
            });
        });
    }

    paginaCompleta = false;
    $.ajax({
        url: url
        , async: async
//        , timeout: 10000 //Espera no máximo 10 segundos,
        , beforeSend: function () {
            if (ignorarMudancas !== true && document.paginaAlterada) {
                var ignorar = confirm("Modificações não salvas. Continuar?");
                if (!ignorar) {
                    return false; //Cancela a chamada Ajax
                } else {
                    setTimeout(function () {
                        if (!paginaCompleta && !ocorreuExcecaoJS) {
                            exibirMensagemCarregando();
                        }
                    }, "1500");
                }
            }

        }
        // A função 'complete' é executada somente depois das funções 'success' e 'error'
        , complete: function () {
            //Ao ocorreu uma exceção JS, as demais páginas carregas após isso não
            //terão seus scripts executados. Para forçar que eles sejam executados,
            //apenas recarregamos a página do navegador para que o JS volte a ser
            //executado.
            if (ocorreuExcecaoJS) {
                document.paginaAlterada = false;
                ocorreuExcecaoJS = false;
                //Previnir um reload infinito caso o erro ocorra na página inicial
                if (!/(index.php($|\?c=inicial&a=(inicial|homepage))|#!(inicial\|homepage))/.test(location.href)) {
                    location.reload(true);
                }
                return false;
            }
            paginaCompleta = true;
            esconderMensagemCarregando();
        }
        , success: function (data, textStatus, jqXHR) {

            if (recipiente !== null) {
                //Trata páginas com títulos personalizados
                var patt = /<title>.*?<\/title>/;
                if (patt.test(data)) {
                    var titulo = patt.exec(data)[0];
                    data = data.replace(titulo, "");
                    titulo = titulo.replace("<title>", "");
                    titulo = titulo.replace("</title>", "");
                    mudarTitulo(titulo);
                } else {
                    //Volta o título para o padrão (para não manter o título da página anterior!)
                    mudarTitulo();
                }
                $(recipiente).empty();
                $(recipiente).append(data);
                _tratarCamposEditaveis();
            }

            fnSucesso();
            document.paginaAlterada = false;
        }

        , error: function (jqXHR, textStatus, errorThrown) {
            paginaCompleta = true;
            esconderMensagemCarregando();
            fnErro();
        }
    });
}

var pfx = ["webkit", "moz", "ms", "o", ""];

function _canToggleFullScreen() {
    var agente = getBrowser().t;
    if (/.*?(Safari|Opera).*?/i.test(agente)) {
        return false;
    }
    var p = 0, m, method = "RequestFullScreen", obj = document.documentElement, t;
    while (p < pfx.length && !obj[m]) {
        m = method;
        if (pfx[p] == "") {
            m = m.substr(0, 1).toLowerCase() + m.substr(1);
        }
        m = pfx[p] + m;

        t = typeof obj[m];
        if (t != "undefined") {
            pfx = [pfx[p]];
            return (t == "function" ? true : false);
        }
        p++;
    }
    return false;
}

function _RunPrefixMethod(obj, method) {

    var p = 0, m, t;
    while (p < pfx.length && !obj[m]) {
        m = method;
        if (pfx[p] == "") {
            m = m.substr(0, 1).toLowerCase() + m.substr(1);
        }
        m = pfx[p] + m;

        t = typeof obj[m];
        if (t != "undefined") {
            pfx = [pfx[p]];
            return (t == "function" ? obj[m](document.documentElement.webkitRequestFullscreen ? Element.ALLOW_KEYBOARD_INPUT : "") : obj[m]);
        }
        p++;
    }

}

function _toggleFullScreen() {
    if (_RunPrefixMethod(document, "FullScreen") || _RunPrefixMethod(document, "IsFullScreen")) {
        _RunPrefixMethod(document, "CancelFullScreen");
        $("div.userInfoWrap  i.icon-resize-small").removeClass("icon-resize-small").addClass("icon-fullscreen");
        $("#fullscreen-toggle").prop('title', "Modo tela cheia");
    } else {
        _RunPrefixMethod(document.documentElement, "RequestFullScreen");

        $("div.userInfoWrap  i.icon-fullscreen").removeClass("icon-fullscreen").addClass("icon-resize-small");
        $("#fullscreen-toggle").prop('title', "Voltar ao modo normal");
    }
    $("#fullscreen-toggle").tooltip('destroy');
    $("#fullscreen-toggle").tooltip({trigger: 'hover', container: 'body', delay: {show: 50, hide: 0}});
}

/**
 * Esconde o rodapé da página.
 * 
 * 
 * @returns {undefined} 
 */
function esconderRodape() {
    if (window.rodapeEscondido === false) {
        window.rodapeEscondido = true;
        $(".footerWrap").animate({
            opacity: 0,
            top: '+=50',
            height: 'toggle'
        }, 500);
        $("footer").animate({
            height: "10px",
            marginTop: "-20px"
        }, 500);
        $(".content").animate({
//            paddingBottom: "30px"
        }, 300, function () {
            $(".arrow-up").show();
            $(".arrow-up").animate({
                opacity: 1
            }, 400);
        });
    }
}

/**
 * Mostra o rodapé da página.
 * 
 * 
 * @returns {undefined} 
 */
function exibirRodape() {
    if (window.rodapeEscondido === true) {
        window.rodapeEscondido = false; //Prevenir clique duplo sobre a seta azul, inutilizando o rodapé
        $(".arrow-up").animate({opacity: 0}, 300, function () {
            $(".arrow-down").show();
            $(".arrow-up").hide();
            $(".footerWrap").animate({
                opacity: 1,
                top: '+=50',
                height: 'toggle'
            }, 400);
            $("footer").animate({
                height: "150",
                marginTop: "-160px"
            }, 400);
            $(".content").animate({
                paddingBottom: "180px"
            }, 500);
        });
    }
}

/**
 * Exibe popup com auxílio do plugin jQuery toastmessage.
 * 
 * 
 * @param {string} mensagem
 * @param {string} tipo
 * @returns {undefined}
 */
function exibirPopup(mensagem, tipo) {
    if (tipo === undefined || tipo === null) {
        tipo = "pop_info";
    }

    var usarFixo = false;
    switch (tipo.toLocaleLowerCase()) {
        case "pop_info_fixo":
            usarFixo = true;
        case "pop_info":
            tipo = "notice";
            break;
        case "pop_erro_fixo":
            usarFixo = true;
        case "pop_erro":
            tipo = "error";
            break;
        case "pop_sucesso_fixo":
            usarFixo = true;
        case "pop_sucesso":
            tipo = "success";
            break;
        case "pop_alerta_fixo":
            usarFixo = true;
        case "pop_alerta":
            tipo = "warning";
            break;
    }
    $().toastmessage('showToast', {
        text: mensagem
        , sticky: usarFixo
        , type: tipo
    });
}

/**
 * Esconde o sub-menu da página caso ele esteja visível.
 * 
 * 
 * @param {int} time Tempo de duração da animação. 200ms por padrão.
 * @returns {undefined}
 */
function _esconderSubmenu(time) {
    if (time === null || time === undefined) {
        time = 200;
    }
    var height = $('.subMenu menu').height();
    var subMenu = $(".subMenu");
//    subMenu.hide({effect: "clip", easing: "easeInOutBounce", duration: time});
    subMenu.addClass("hidden");
    subMenu.animate({
        top: (-1) * height,
        opacity: 0.0,
        display: "none"
    }, time);
}

/**
 * Mostra o sub-menu.
 * 
 * 
 * @param {int} time Tempo de duração da animação. 200ms por padrão.
 * @returns {undefined}
 */
function _exibirSubmenu(time) {
    if (time === null || time === undefined) {
        time = 200;
    }
    var subMenu = $(".subMenu");
//    subMenu.show({effect: "clip", easing: "easeInOutBounce", duration: time});
    subMenu.removeClass("hidden");
    subMenu.animate({
        top: "0px",
        opacity: "1",
        display: "inline-block"
    }, time);
}
/**
 * Função responsável pelo funcionamento do menu.
 * 
 * @author Reuel
 * 
 * @param {json} originMenu Menu onde o clique foi originado.
 * @returns {undefined}
 */
function _contruirSubmenus(originMenu) {
    var menuName;
    if (originMenu !== null) {
        menuName = originMenu.id;
    } else {
        $(".subMenu menu ul").addClass("hiddenSubMenuLink");
        return;
        menuName = "homeLink";
    }

    menuName = menuName.substring(0, menuName.lastIndexOf("Link"));
    menuName = menuName.concat("SubMenu");
    //alert(menuName);
    var subMenus = $(".subMenu menu ul");

    for (var i = 0; i < subMenus.length; i++) {

        $(subMenus[i]).addClass("hiddenSubMenuLink");

    }

    try {
        for (var i = 0; i < subMenus.length; i++) {
            if (subMenus[i].classList.contains(menuName)) {
                subMenus[i].classList.remove("hiddenSubMenuLink");

                subMenus[i].onclick = function () {
                    $(".actualTool").removeClass('actualTool');
                    $('.menuLink.visited').addClass('actualTool');
                };
                break;
            }
        }
    } catch (e) {
        //fix for IE
        for (var i = 0; i < subMenus.length; i++) {
            if (subMenus[i].className.search(menuName) != -1) {
                $(subMenus[i]).removeClass("hiddenSubMenuLink");
                break;
            }
            subMenus[i].onclick = function () {
                $(".actualTool").removeClass('actualTool');
                $('.menuLink.visited').addClass('actualTool');
            };
        }
    }
}

/**
 * Muda o título da página, mas mudando apenas o final. O título padrão é "Controle CEAD".
 * Caso você altere o título para "Nova página" o resultado então seria: "Nova página | Controle CEAD".
 * O título padrão pode ser omitido.
 * 
 * @author Reuel
 * 
 * @param {string} titulo Titulo para ser adicionado ao título padrão.
 * @param {boolean} ignorarTituloPadrao Omite ou não o título padrão.
 */
function mudarTitulo(titulo, ignorarTituloPadrao) {

    if (ignorarTituloPadrao === undefined) {
        ignorarTituloPadrao = false;
    }
    if (titulo !== undefined) {
        var tituloPadrao = ignorarTituloPadrao ? "" : "Controle CEAD";
        $("title").empty();
        $("title").append(titulo + " | " + tituloPadrao);
    } else {
        $("title").empty();
        $("title").append(tituloPadrao);
    }
}

function carregarModal(url) {
    $.ajax(url, {
        success: function () {
            var $titulo = obterResposta('sys_modal_header');
            var $corpo = obterResposta('sys_modal_body');
            carregarHeader($titulo);
            carregarCorpo($corpo);
//            $("#myModal").load(url).modal();
            $("#myModal").modal({backdrop: "static"});
        }
    });


    function carregarHeader(dados) {
        $("#myModalLabel").empty();
        $("#myModalLabel").append(dados);
    }

    function carregarCorpo(dados) {
        $("#myModalBody").empty();
        $("#myModalBody").append(dados);
    }
}