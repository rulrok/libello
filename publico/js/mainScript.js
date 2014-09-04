window.menuColou = false;
//De fato a página está configurada para exibir ele, e o script para esconde-lo é executado
//na primeira renderização da página, por tanto, window.footerHidden deve estar inicialmente
//configurado como false.
window.footerHidden = false;
//Usado para quando se muda de página para não sair por engano e perder dados.
document.paginaAlterada = false;
//Um fix
document.ignorarHashChange = false;

// This script sets OSName variable as follows:
// "Windows"    for all versions of Windows
// "MacOS"      for all versions of Macintosh OS
// "Linux"      for all versions of Linux
// "UNIX"       for all other UNIX flavors 
// "Unknown OS" indicates failure to detect the OS

var OSName = "Unknown OS";
if (navigator.appVersion.indexOf("Win") != -1)
    OSName = "Windows";
if (navigator.appVersion.indexOf("Mac") != -1)
    OSName = "MacOS";
if (navigator.appVersion.indexOf("X11") != -1)
    OSName = "UNIX";
if (navigator.appVersion.indexOf("Linux") != -1)
    OSName = "Linux";


//----------------------------------------------------------------------//
//                          FUNÇÕES                                     //
//----------------------------------------------------------------------//

/**
 * Função auxiliar, executada quando um link é clicado, para antes que uma hash
 * seja mudada no endereço da url, caso um formulário esteja sendo editado,
 * a funcão vai impedir isso, perguntando se o usuário deseja realmente sair
 * da página atual ainda não salva.
 * 
 * @author Reuel
 * 
 * @param {type} evt
 * @returns {undefined}
 */
function confirmarDadosNaoSalvos(evt) {
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
 * @param {type} evt
 * @returns {undefined}
 */
function requererPaginaAtual(evt) {
    var index = this.href.lastIndexOf("#")
    var hash = this.href.substring(index);
    if (location.hash == hash) {
        if (!document.paginaAlterada) {
            carregarPagina(hash);
        }

    }
}

function getBrowser() {
    var n, v, t, ua = navigator.userAgent;
    var names = {i: 'Internet Explorer', f: 'Firefox', o: 'Opera', s: 'Apple Safari', n: 'Netscape Navigator', c: "Chrome", x: "Other"};
    if (/bot|googlebot|slurp|mediapartners|adsbot|silk|android|phone|bingbot|google web preview|like firefox|chromeframe|seamonkey|opera mini|min|meego|netfront|moblin|maemo|arora|camino|flot|k-meleon|fennec|kazehakase|galeon|android|mobile|iphone|ipod|ipad|epiphany|rekonq|symbian|webos/i.test(ua))
        n = "x";
    else if (/Trident.(\d+\.\d+)/i.test(ua))
        n = "io";
    else if (/MSIE.(\d+\.\d+)/i.test(ua))
        n = "i";
    else if (/Opera.*Version.(\d+\.?\d+)/i.test(ua))
        n = "o";
    else if (/Opera.(\d+\.?\d+)/i.test(ua))
        n = "o";
    else if (/OPR.(\d+\.?\d+)/i.test(ua))
        n = "o";
    else if (/Chrome.(\d+\.\d+)/i.test(ua))
        n = "c";
    else if (/Firefox.(\d+\.\d+)/i.test(ua))
        n = "f";
    else if (/Version.(\d+.\d+).{0,10}Safari/i.test(ua))
        n = "s";
    else if (/Safari.(\d+)/i.test(ua))
        n = "so";
    else if (/Netscape.(\d+)/i.test(ua))
        n = "n";
    else
        return {n: "x", v: 0, t: names[n]};
    if (n == "x")
        return {n: "x", v: 0, t: names[n]};

    v = new Number(RegExp.$1);
    if (n == "so") {
        v = ((v < 100) && 1.0) || ((v < 130) && 1.2) || ((v < 320) && 1.3) || ((v < 520) && 2.0) || ((v < 524) && 3.0) || ((v < 526) && 3.2) || 4.0;
        n = "s";
    }
    if (n == "i" && v == 7 && window.XDomainRequest) {
        v = 8;
    }
    if (n == "io") {
        n = "i";
        if (v > 5)
            v = 10;
        else if (v > 4)
            v = 9;
        else if (v > 3.1)
            v = 8;
        else if (v > 3)
            v = 7;
        else
            v = 9;
    }
    return {n: n, v: v, t: names[n] + " " + v}
}

/**
 * Função para 'colar' o menu quando a página descer. Perceba que a função é otimizada.
 * Ela não fica refazendo operações desnecessárias, como atualizar o css do menu
 * sem necessidade. Em suma, ela detecta quando de fato o menu deve ser desprendido
 * e quando deve ser colado superiormente, através da variável window.menuColou.
 * 
 * @author Reuel
 * 
 * @returns {undefined}
 */
function acoplarMenu() {
    var menu = $("#menuPosition");
    var menuPosition = menu.position().top;
    var windowPosition = $(window).scrollTop();
    if (!window.menuColou && windowPosition >= menuPosition) {
        window.menuColou = true;
        /*  MENU FIXADO  */
        hideSubMenu(400);
        $("#barra_superior").show(800);
        var divMenu = $(".menuContainer");
        var menuHeight = divMenu.height();
        divMenu.addClass("fixedMenu");
        divMenu.css('position', 'fixed');
        divMenu.css('top', '0px');
        divMenu.css('width', '100%');
        var divContent = $(".content");
        divContent.css('padding-top', menuHeight + 'px');

        //Trata div do popup
        var popup = $(".popUp");
        var alturaMenu = $(".menu").height();
        $(popup).css('position', 'fixed');
        $(popup).css('left', '10px');
        $(popup).css('top', alturaMenu + 40 + 'px');

        $(".menuContainer").hover(function() {
            showSubMenu(100)
        }, function() {
            hideSubMenu(20)
        });
        $(".subMenu").mouseenter(function() {
            $(".menuContainer").css('background', 'url("publico/imagens/backgroundMenu.png")')
        })
    } else if (window.menuColou && windowPosition < menuPosition) {
        window.menuColou = false;
        $("#barra_superior").hide(500);
        showSubMenu();
        /*  MENU NORMAL  */
        var divMenu = $(".menuContainer");
        divMenu.removeClass("fixedMenu");
        divMenu.css('position', 'relative');
        divMenu.css('top', '0px');
        var divContent = $(".content");
        divContent.css('padding-top', '0px');

        //Trata div do popup
        var popup = $(".popUp");
        var alturaMenu = $(".menu").height();
        var alturaHeader = $("header").height();
        $(popup).css('position', 'absolute');
        $(popup).css('left', '10px');
        $(popup).css('top', alturaMenu + alturaHeader + 40 + "px");

        $(".menuContainer").unbind("mouseenter mouseleave")
    }
}
/**
 * Função que carrega uma página, com auxílio da função <code>ajax</code>, com
 * base em um meta-link formatado da seguinte maneira:
 *  #![nomeControlador]|[nomeAcao](lista opcional de parâmetros GET).<br/>
 * Em outras palavras, o link deve casar com a expressão regular: <code>^#![a-z]+\|[a-z]+((\&[a-zA-Z]+=[a-z0-9]*)+)?</code>
 * 
 * @author Reuel
 * 
 * @param {string} link Página a ser carregada
 * @returns {undefined}
 */
function carregarPagina(link) {
    // Get the hash (fragment) as a string, with any leading # removed. Note that
    // in jQuery 1.4, you should use e.fragment instead of $.param.fragment().

    if (link === undefined || link === null | !link.match("^#![a-z]+\|[a-z]+((\&[a-zA-Z]+=[a-z0-9]*)+)?")) {
        return undefined;
    }
    var url = "index.php?c=<c>&a=<a>";


    var novolink = link.replace("#!", "");
    novolink = novolink.split("|");

    if (novolink[1] === "inicial") { //Importante para não causar um loop infinito na página.
        novolink[1] = "404";
    }
    url = url.replace("<c>", novolink[0]);
    url = url.replace("<a>", novolink[1]);

    var resultadoOperacao = ajax(url);
    if (resultadoOperacao === false) {
        return false;
    }
    if (link !== location.hash) {
        history.pushState(null, null, link);
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
            makeSubMenu(menuObj);
            showSubMenu();
        }
    } catch (ex) {
        $(".menuLink[id^=" + menu + "]").addClass("actualTool");
        $(".menuLink[id^=" + menu + "]").addClass("visited");
        var menuObj = new Object();
        menuObj.id = menu + "Link";
        makeSubMenu(menuObj);
        showSubMenu();
    }
}

function exibirShader() {
    $(".loading_background").css("display", "initial");
    $(".shaderFrame").css("visibility", "visible").animate({opacity: "0.5"}, 150);
    $(".shaderFrameContent").css("visibility", "visible").animate({opacity: "1"}, 350);
    $(".shaderFrameContent").center();
}

function esconderShader() {
    $(".loading_background").css("display", "none");
    $(".shaderFrame").css("visibility", "hidden").css("opacity", "0");
    $(".shaderFrameContent").css("visibility", "hidden").css("opacity", "0");
}
/**
 * Faz uma requisição Ajax de alguma página qualquer, podendo escolher onde a 
 * resposta será colocada.
 * 
 * @author Reuel
 * 
 * @param {URL} link URL para a página que deseja-se obter via ajax.
 * @param {String} place Um div (ou até mesmo um SPAN) referenciado pelo nome da sua classe
 * ou ID, onde a resposta será inserida. Caso seja <code>undefined</code>, <i>.contentWrap</i> será utilizado
 * por padrão. Caso <code>null</code>, a resposta não será colocada em nenhum lugar.
 * @param {boolean} hidePop Determina se, caso um pop-up esteja sendo exibido no canto da tela do usuário,
 * se ele deve ser escondido ou permanecer sendo exibido.
 * @param {boolean} async Especifíca se o carregamento deve ser assíncrono ou não. Por padrão, essa opção é falsa.
 * @param {boolean} ignorePageChanges Faz a chamada sem perguntar se o usuário deseja sair, caso tenho feito alguma alteração no documento.
 * @returns O retorno da página requisitada, caso ela retorne algum.
 */
function ajax(link, place, hidePop, async, ignorePageChanges) {
    if (place === undefined) {
        place = ".contentWrap";
    }
    if (async === undefined || async === null) {
        async = true;
    }

    paginaCompleta = false;
    var request = $.ajax({
        url: link
        , async: async
                //, timeout: 10000 //Espera no máximo 10 segundos,
        , beforeSend: function() {
//            if (place !== null) {
            setTimeout(function() {
                if (!paginaCompleta && !ocorreuExcecaoJS) {
                    exibirShader();
                }
            }, "1500");
//            }
        }
        , complete: function() {
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
            esconderShader();
        }
        , error: function() {
            paginaCompleta = true;
            esconderShader();
        }
    });

    var sucesso = request.success(function(data) {

        if (ignorePageChanges === undefined || ignorePageChanges === false) {
            if (document.paginaAlterada) {
                var ignorarMudancas = confirm("Modificações não salvas. Continuar?");
                if (!ignorarMudancas) {
                    return false;
                }
            }
        }
        document.paginaAlterada = false;
        if (place !== null) {
            $(place).empty();
            var patt = new RegExp("<title>.*?</title>.*?");
//            window.alert(data);
//            var tituloProprio = data.lastIndexOf("<title>");

            //Trata páginas com títulos personalizados
            if (data !== undefined && data !== null) {
                if (patt.test(data)) {
                    var titulo = patt.exec(data)[0];
                    data = data.replace(titulo, "");
                    titulo = titulo.replace("<title>", "");
                    titulo = titulo.replace("</title>", "");
                    mudarTitulo(titulo);
                } else {
                    //Volta o título para o padrão
                    mudarTitulo();
                }
                $(place).append(data);
            }
        }
//        //Caso o conteúdo seja carregado no popup com fundo cinza
//        if (place == ".shaderFrameContentWrap") {
//            $(".shaderFrame").css("visibility", "visible").animate({opacity: "0.5"}, 150);
//            $(".shaderFrameContent").css("visibility", "visible").animate({opacity: "1"}, 350);
//            $(".shaderFrameContent").center();
//        }

        //TODO encontrar uma forma de tratar os campos somente leitura dos datapickers, pois quando
        //é escolhida uma data através do jquery, o evento change não é acionado.
        var camposAlteraveis = $("input, select, textarea").not('.ignorar').not("[hidden]").not("[readonly]");
        $(camposAlteraveis).bind("keyup", function(param) {
            if (param.keyCode != 13)
                conteudoAlterado();
        });
        $(camposAlteraveis).bind("change", function(param) {
            if (param.keyCode != 13)
                conteudoAlterado();
        });
        var camposData = $(".campoData").not(".ignorar");

        $(camposData).on("mousedown", function(e) {
            $(camposData).on("mouseup", function(param) {
                setTimeout(function() {
                    if (param.keyCode != 13)
                        conteudoAlterado();
                }, 300);
            });
        });

        if (hidePop === undefined) {
            hidePop = true;
        }
        if (hidePop === true) {
            hidePopUp();
        }
//        return data;
    });
    var erro = request.error(function(jqXHR, textStatus, errorThrown) {
        if (textStatus != "timeout") {
            showPopUp("<b>" + errorThrown.name + "</b><br/>" + errorThrown.message, textStatus);
        } else {
            showPopUp("<B>Timeout</b><br/>A operação não pode ser concluída pois o servidor demorou muito para responder.", "Info");
        }
    });


    return sucesso.responseText;
}

//funcao temporaria para debug
function conteudoAlterado() {
    document.paginaAlterada = true;
}
//TODO verificar porque a tela cheia não funciona, através desse método, do mesmo
//modo que apertando F11 (ou botão apropriado para exibir em tela cheia) no navegador.
//function launchFullScreen(element) {
//
//    if (element.requestFullScreen) {
//        element.requestFullScreen();
//    } else if (element.mozRequestFullScreen) {
//        element.mozRequestFullScreen();
//    } else if (element.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT)) {
//        element.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
//    } else {
//        var wscript = new ActiveXObject("Wscript.shell");
//        wscript.SendKeys("{F11}");
//
//    }
//    $("#fullscreen-on").addClass("hide");
//    $("#fullscreen-off").removeClass("hide");
//}
//
//function cancelFullscreen() {
//
//    if (document.cancelFullScreen) {
//        document.cancelFullScreen();
//    } else if (document.mozCancelFullScreen) {
//        document.mozCancelFullScreen();
//    } else if (document.webkitCancelFullScreen) {
//        document.webkitCancelFullScreen();
//    } else {
//        var wscript = new ActiveXObject("Wscript.shell");
//        wscript.SendKeys("{F11}");
//    }
//    $("#fullscreen-off").addClass("hide");
//    $("#fullscreen-on").removeClass("hide");
//}

var pfx = ["webkit", "moz", "ms", "o", ""];

function canToggleFullScreen() {
//    if (document.documentElement.requestFullscreen) {
//        return true;
//    } else if (document.documentElement.mozRequestFullScreen) {
//        return true;
//    } else if (document.documentElement.webkitRequestFullscreen) {
//        return true;
//    } else {
//        try {
//            var wscript = new ActiveXObject("Wscript.shell");
//            return true;
//        } catch (e) {
//        }
//    }
//    return false;
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

function RunPrefixMethod(obj, method) {

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

function toggleFullScreen() {
//    if (!document.fullscreenElement && // alternative standard method
//            !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods
//        if (document.documentElement.requestFullscreen) {
//            document.documentElement.requestFullscreen();
//        } else if (document.documentElement.mozRequestFullScreen) {
//            document.documentElement.mozRequestFullScreen();
//        } else if (document.documentElement.webkitRequestFullscreen) {
//            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
//        } else {
//            var wscript = new ActiveXObject("Wscript.shell");
//            wscript.SendKeys("{F11}");
//        }
//        $("div.userInfoWrap  i.icon-fullscreen").removeClass("icon-fullscreen").addClass("icon-resize-small");
//        $("#fullscreen-toggle").prop('title', "Voltar ao modo normal");
//    } else {
//        if (document.cancelFullScreen) {
//            document.cancelFullScreen();
//        } else if (document.mozCancelFullScreen) {
//            document.mozCancelFullScreen();
//        } else if (document.webkitCancelFullScreen) {
//            document.webkitCancelFullScreen();
//        } else {
//            var wscript = new ActiveXObject("Wscript.shell");
//            wscript.SendKeys("{F11}");
//        }
//        $("div.userInfoWrap  i.icon-resize-small").removeClass("icon-resize-small").addClass("icon-fullscreen");
//        $("#fullscreen-toggle").prop('title', "Modo tela cheia");
//
//    }
    if (RunPrefixMethod(document, "FullScreen") || RunPrefixMethod(document, "IsFullScreen")) {
        RunPrefixMethod(document, "CancelFullScreen");
        $("div.userInfoWrap  i.icon-resize-small").removeClass("icon-resize-small").addClass("icon-fullscreen");
        $("#fullscreen-toggle").prop('title', "Modo tela cheia");
    } else {
        RunPrefixMethod(document.documentElement, "RequestFullScreen");

        $("div.userInfoWrap  i.icon-fullscreen").removeClass("icon-fullscreen").addClass("icon-resize-small");
        $("#fullscreen-toggle").prop('title', "Voltar ao modo normal");
    }
    $("#fullscreen-toggle").tooltip('destroy');
    $("#fullscreen-toggle").tooltip({trigger: 'hover', container: 'body', delay: {show: 50, hide: 0}});
}

/**
 * Esconde o rodapé da página.
 * 
 * @author Reuel
 * 
 * @returns {undefined} 
 */
function hideFooter() {
    if (window.footerHidden === false) {
        window.footerHidden = true;
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
        }, 300, function() {
            $(".arrow-up").show();
            $(".arrow-up").animate({
                opacity: 1
            }, 400);
        });
    }
}

/**
 * Mostra o rodapé da página. Por padão ela fica escondida para ganhar espaço.
 * 
 * @author Reuel
 * 
 * @returns {undefined} 
 */
function showFooter() {
    if (window.footerHidden === true) {
        window.footerHidden = false; //Prevenir clique duplo sobre a seta azul, inutilizando o rodapé
        $(".arrow-up").animate({opacity: 0}, 300, function() {
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
 * Exibe um balão de aviso no centro da tela. Você pode personalizar o
 * tipo de aviso.
 * 
 * @author Reuel
 * 
 * @param {string} data
 * @param {string} type 'sucesso', 'erro' ou 'informacao'. Por padrão, 'informacao'.
 * @returns {undefined}
 */
function showPopUp(data, type) {
    if (type === undefined || type === null) {
        type = "informacao";
    }
    var texto, fundo, borda;
    switch (type.toLocaleLowerCase()) {
        case "informacao":
        case "info":
            texto = "#3a87ad !important";
            fundo = "#d9edf7";
            borda = "#bce8f1";
            type="showNoticeToast";
            break;
        case "error":
        case "erro":
            texto = "#b94a48 !important";
            fundo = "#f2dede";
            borda = "#eed3d7";
            type="showErrorToast";
            break;
        case "sucesso":
        case "success":
            texto = "#468847 !important";
            fundo = "#dff0d8";
            borda = "#d6e9c6";
            type="showSuccessToast";
            break;
    }
    $().toastmessage(type, data);

//    $(".popUpContent").empty();
//    $(".popUp").css('color', texto);
//    $(".popUp").css('background-color', fundo);
//    $(".popUp").css('border-color', borda);
////    $(".popUp").css('left', 480);
//    $(".popUp").css('left', 570);
//    $(".popUpContent").append(data);
//    $(".popUp").show(200, function() {
//        $(".botao_fechar").show(100, function() {
//            $(".popUp").css("display", "table");
//            //Aplica o efeito de lightbox (esmaece o fundo e destaca o popUp)
//            $(".shaderFrame").css("visibility", "visible").animate({opacity: "0.5"}, 150);
//        });
//        $(this).effect("shake", {}, 500);
//    });
    
    //Trecho sem efeito de esmaecimento
    //    $(".popUp").show(200, function() {
    //        $(".botao_fechar").show(100, function() {
    //            $(".popUp").css("display", "table");
    //        });
    //        $(this).effect("shake", {}, 500);
    //    });
}

/**
 * Esconde o pop-up central da página.
 * 
 * @author Reuel
 * 
 * @returns {undefined}
 */
function hidePopUp() {
    $(".botao_fechar").hide(100, function() {
        $(".popUp").hide(200, function() {
            $(".sub_popUp").empty();
            //Fecha o esmaecimento cinza ao fundo logo que se fechar o pop-up
            $(".shaderFrame").css("visibility", "hidden").css("opacity", "0");
        });
    });



}

/**
 * Esconde o sub-menu.
 * 
 * @author Reuel
 * 
 * @param {int} time Tempo de duração da animação.
 * @returns {undefined}
 */
function hideSubMenu(time) {
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
 * @author Reuel
 * 
 * @param {int} time Tempo de duração da animação.
 * @returns {undefined}
 */
function showSubMenu(time) {
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
 * @param {json} Menu onde o clique foi originado.
 * @returns {undefined}
 */
function makeSubMenu(originMenu) {
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

                subMenus[i].onclick = function() {
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
            subMenus[i].onclick = function() {
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

/**
 * Procura por uma resposta JSON. Especififamente feito para as respostas de páginas,
 * como por exemplo, páginas de edições, alterações, ou quando deleta-se algum item.
 * Isso precisa ser melhorado, mas por enquanto, funciona bem =).
 * 
 * @author Reuel
 *  
 * @param {String} string Texto qualquer. Nesse caso, trata-se do retorno das páginas solicitadas via Ajax.
 * @returns {String} String para ser criado um Json, caso alguma seja encontrada.
 */
function extrairJSON(string) {
    var json = null;
    try {
        json = $.parseJSON(string);
    } catch (ex) {
        var index = string.lastIndexOf('{"status":');
        if (index > -1)
            return extrairJSON(string.substring(index));
        else
            json = '{"status":"Informacao","mensagem":"Ocorreu algum erro no processamento da resposta do servidor.<br/>Verifique manualmente se o dado foi cadastrado."}';
    }
    return json;
}
