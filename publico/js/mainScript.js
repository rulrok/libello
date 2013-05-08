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
    $('.shaderFrameContent').draggable({cancel: ".shaderFrameContentWrap", });

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
        var divMenu = $(".menuContainer");
        var menuHeight = divMenu.height();
        divMenu.css('position', 'fixed');
        divMenu.css('top', '0px');
        divMenu.css('width', '100%');
        var divContent = $(".content");
        divContent.css('padding-top', menuHeight + 'px');
    } else if (window.menuHasUpped && windowPosition < menuPosition) {
        window.menuHasUpped = false;
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
    switch (type) {
        case "informacao":
            texto = "#3a87ad !important";
            fundo = "#d9edf7";
            borda = "#bce8f1";
            break;
        case "erro":
            texto = "#b94a48 !important";
            fundo = "#f2dede";
            borda = "#eed3d7";
            break;
        case "sucesso":
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
        time = 350;
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
    }, 350);
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
        }
    }
}

function ajax(link, place)
{
    if (place == null) {
        place = ".contentWrap";
    }
    $.ajax({
        url: link
    }).done(function(data) {

        if (document.paginaAlterada) {
            var ignorarMudanças = confirm("Modificações não salvas. Continuar?");
            if (!ignorarMudanças) {
                return false;
            }
        }
        document.paginaAlterada = false;
        $(place).empty();
        $(place).append(data);
        //Caso o conteúdo seja carregado no popup com fundo cinza
        if (place == ".shaderFrameContentWrap") {
            $(".shaderFrame").css("visibility", "visible").animate({opacity: "0.5"}, 150);
            $(".shaderFrameContent").css("visibility", "visible").animate({opacity: "1"}, 350);
            $(".shaderFrameContent").center();
        }

        $("input, select").not('.ignorar').not('.dataTables_filter input').change(function() {
            document.paginaAlterada = true;
        });
        //eval(document.getElementById("pos_script").innerHTML);
        hidePopUp();
    });
}

function mudarTitulo(titulo){
    tituloPadrao = "Controle CEAD | ";
    $("title").empty();
    $("title").append(tituloPadrao + titulo);    
}