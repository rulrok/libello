var $buoop = {};
$buoop.ol = window.onload;
window.menuHasUpped = false;
//Usado para quando se muda de página para não sair
//por engano e perder dados.
document.paginaAlterada = false;

//Prepara algumas funções especiais e conteúdos para serem exibidos no início
window.onload = function() {

    //Função para centralizar elementos na página de acordo com o tamanho da tela
    jQuery.fn.center = function() {
        this.css("position", "absolute");
        this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
                $(window).scrollTop()) + "px");
        this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
                $(window).scrollLeft()) + "px");
        return this;
    };

    //Para que quando a tela redimensionar e o popup com fundo cinza estiver sendo exibido,
    //ele seja centralizado novamente, evitando exibições estranhas
    window.onresize = function() {
        $(".shaderFrameContent").center();
    };

    //Permite que o popup seja arrastado pela tela
    $('.shaderFrameContent').draggable({cancel: ".shaderFrameContentWrap"});

    $(".shaderFrame").click(function() {
        $(".shaderFrame").css("visibility", "hidden").css("opacity", "0");
        $(".shaderFrameContent").css("visibility", "hidden").css("opacity", "0");
    });

    hideFooter();

    $(".popUp").hide();
    if (!String.prototype.trim) {
        String.prototype.trim = function() {
            return this.replace(/^\s+|\s+$/g, '');
        }
    }

    //Função para detectar navegadores antigos
    try {
        if ($buoop.ol)
            $buoop.ol();
    } catch (e) {
    }
    var e = document.createElement("script");
    e.setAttribute("type", "text/javascript");
    e.setAttribute("src", "http://browser-update.org/update.js");
    document.body.appendChild(e);


    //Associa uma função para todos os links do menu
    var menus = $('.menuLink');
    for (var i = 0; i < menus.length; i++) {
        if (menus[i].id == "homeLink") {
            menus[i].onclick = function() {
                $(".menuLink.visited").removeClass("visited");
                $(this).addClass("visited");
                $(".actualTool").removeClass('actualTool');

                hideSubMenu(150);
            }
            continue;
        }
        menus[i].onclick = function() {
            var id = this.id;
            if (!this.className.match(".*visited.*")) {
                $(".menuLink.visited").removeClass("visited");
                $(this).addClass("visited");
                hideSubMenu(0);
                makeSubMenu(this);
                showSubMenu();
            } else {
                if ($(".subMenu").css("opacity") == "1") {
                    hideSubMenu();
                } else {
                    showSubMenu();
                }
            }
        };
    }
};

//Função para manter o menu 'colado' no topo da página quando ela desce muito
window.onscroll = function() {
    var menu = $("#menuPosition");
    var menuPosition = menu.position().top;
    var windowPosition = $(window).scrollTop();
    if (!window.menuHasUpped && windowPosition >= menuPosition) {
        window.menuHasUpped = true;
        //console.debug("Fixou o menu");
        $("#barra_superior").show(800);
        var divMenu = $(".menuContainer");
        var menuHeight = divMenu.height();
        divMenu.css('position', 'fixed');
        divMenu.css('top', '0px');
        divMenu.css('width', '100%');
        var divContent = $(".content");
        divContent.css('padding-top', menuHeight + 'px');
    } else if (window.menuHasUpped && windowPosition < menuPosition) {
        window.menuHasUpped = false;
        $("#barra_superior").hide(500);
        //console.debug("Retornou ao normal");
        var divMenu = $(".menuContainer");
        divMenu.css('position', 'relative');
        divMenu.css('top', '0px');
        var divContent = $(".content");
        divContent.css('padding-top', '0px');
    }
};

function launchFullScreen(element) {

    if (element.requestFullScreen) {
        element.requestFullScreen();
    } else if (element.mozRequestFullScreen) {
        element.mozRequestFullScreen();
    } else if (element.webkitRequestFullScreen) {
        element.webkitRequestFullScreen();
    } else {
        var wscript = new ActiveXObject("Wscript.shell");
        wscript.SendKeys("{F11}");

    }
    $("#fullscreen-on").addClass("hide");
    $("#fullscreen-off").removeClass("hide");
}

function cancelFullscreen() {

    if (document.cancelFullScreen) {
        document.cancelFullScreen();
    } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
    } else if (document.webkitCancelFullScreen) {
        document.webkitCancelFullScreen();
    }
    $("#fullscreen-off").addClass("hide");
    $("#fullscreen-on").removeClass("hide");
}

function hideFooter() {
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
        paddingBottom: "30px"
    }, 700, function() {
        $(".arrow-up").show();
        $(".arrow-up").animate({
            opacity: 1
        }, 200);
    });
}

function showFooter() {
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

/**
 * Exibe um balão de aviso no canto direito da tela. Você pode personalizar o
 * tipo de aviso.
 * @param {type} data
 * @param {type} type 'sucesso', 'erro' ou 'informacao'. Por padrão, 'informacao'.
 * @returns {undefined}
 */
function showPopUp(data, type) {
    if (type == null) {
        type = "informacao";
    }
    var texto, fundo, borda;
    switch (type.toLocaleLowerCase()) {
        case "informacao":
        case "info":
            texto = "#3a87ad !important";
            fundo = "#d9edf7";
            borda = "#bce8f1";
            break;
        case "error":
        case "erro":
            texto = "#b94a48 !important";
            fundo = "#f2dede";
            borda = "#eed3d7";
            break;
        case "sucesso":
        case "success":
            texto = "#468847 !important";
            fundo = "#dff0d8";
            borda = "#d6e9c6";
            break;
    }

    $(".popUpContent").empty();
    $(".popUp").css('color', texto);
    $(".popUp").css('background-color', fundo);
    $(".popUp").css('border-color', borda);
    $(".popUpContent").append(data);
    $(".popUp").show(200, function() {
        $(".botao_fechar").show(100, function() {
            $(".popUp").css("display", "table");
        });
    });
}

function hidePopUp() {
    $(".botao_fechar").hide(100, function() {
        $(".popUp").hide(200, function() {
            $(".sub_popUp").empty();
        })
    });



}
function hideSubMenu(time) {
    if (time === null) {
        time = 200;
    }
    var height = $('.subMenu menu').height();
    var subMenu = $(".subMenu");
    subMenu.animate({
        top: (-1) * height,
        opacity: 0.0,
        display: "none"
    }, time);
}

function showSubMenu() {
    var subMenu = $(".subMenu");
    subMenu.animate({
        top: "0px",
        opacity: "1",
        display: "inline-block"
    }, 200);
}

function makeSubMenu(originMenu) {
    var menuName;
    if (originMenu !== null) {
        menuName = originMenu.id;
    } else {
        menuName = "homeLink";
    }

    menuName = menuName.substring(0, menuName.lastIndexOf("Link"));
    menuName = menuName.concat("SubMenu");
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
 * Faz uma requisição Ajax de alguma página qualquer, podendo escolher onde a 
 * resposta será colocada.
 * 
 * @param {URL} link URL para a página que deseja-se obter via ajax.
 * @param {String} place Um div (ou até mesmo um SPAN) referenciado pelo nome da sua classe
 * ou ID, onde a resposta será inserida. Caso seja <code>undefined</code>, <i>.contentWrap</i> será utilizado
 * por padrão. Caso <code>null</code>, a resposta não será colocada em nenhum lugar.
 * @param {boolean} hidePop Determina se, caso um pop-up esteja sendo exibido no canto da tela do usuário,
 * se ele deve ser escondido ou permanecer sendo exibido.
 * @param {boolean} async Especifíca se o carregamento deve ser assíncrono ou não. Por padrão, essa opção é falsa.
 * @returns O retorno da página requisitada, caso ela retorne algum.
 */
function ajax(link, place, hidePop,async) {
    if (place === undefined) {
        place = ".contentWrap";
    }
    if (async === undefined || async === null){
        async = true;
    }
    var request = $.ajax({
        url: link,
        async: async,
        timeout: 5000 //Espera no máximo 5 segundos
    });

    var sucesso = request.success(function(data) {

        if (place !== null) {
            if (document.paginaAlterada) {
                var ignorarMudancas = confirm("Modificações não salvas. Continuar?");
                if (!ignorarMudancas) {
                    return false;
                }
            }
            document.paginaAlterada = false;
            $(place).empty();
            $(place).append(data);
        }
//        //Caso o conteúdo seja carregado no popup com fundo cinza
//        if (place == ".shaderFrameContentWrap") {
//            $(".shaderFrame").css("visibility", "visible").animate({opacity: "0.5"}, 150);
//            $(".shaderFrameContent").css("visibility", "visible").animate({opacity: "1"}, 350);
//            $(".shaderFrameContent").center();
//        }

        //TODO encontrar uma forma de tratar os campos somente leitura dos datapickers, pois quando
        //é escolhida uma data através do jquery, o evento change não é acionado.
        $("input, select").not('.ignorar').not('.dataTables_filter input').change(function() {
            document.paginaAlterada = true;
        });

        if (hidePop === undefined) {
            hidePop = true;
        }
        if (hidePop === true) {
            hidePopUp();
        }
        return data;
    });

    var erro = request.error(function(jqXHR, textStatus, errorThrown) {
        if (textStatus != "timeout") {
            showPopUp("<b>" + errorThrown.name + "</b><br/>" + errorThrown.message, textStatus);
        } else {
            showPopUp("Timeout. A operação não pode ser concluída pois o <br/>servidor demorou muito para responder.", "Info");
        }
    });


    return sucesso.responseText;
}

// this function create an Array that contains the JS code of every <script> tag in parameter
// then apply the eval() to execute the code in every script collected
function parseScript(strcode) {
    var scripts = new Array();         // Array which will store the script's code

    // Strip out tags
    while (strcode.indexOf("<script") > -1 || strcode.indexOf("</script") > -1) {
        var s = strcode.indexOf("<script");
        var s_e = strcode.indexOf(">", s);
        var e = strcode.indexOf("</script", s);
        var e_e = strcode.indexOf(">", e);

        // Add to scripts array
        scripts.push(strcode.substring(s_e + 1, e));
        // Strip from strcode
        strcode = strcode.substring(0, s) + strcode.substring(e_e + 1);
    }

    // Loop through every script collected and eval it
    for (var i = 0; i < scripts.length; i++) {
        try {
            eval(scripts[i]);
        }
        catch (ex) {
            // do what you want here when a script fails
        }
    }
}

function mudarTitulo(titulo) {
    tituloPadrao = "Controle CEAD | ";
    $("title").empty();
    $("title").append(tituloPadrao + titulo);
}

/**
 * Procura por uma resposta JSON. Especififamente feito para as respostas de páginas,
 * como por exemplo, páginas de edições, alterações, ou quando deleta-se algum item.
 * 
 * @param {String} String qualquer. Nesse caso, trata-se do retorno das páginas solicitadas via Ajax.
 * @returns {String} String para ser criado um Json, caso alguma seja encontrada.
 */
function extrairJSON(string) {
    console.log(string);
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
