
var $buoop = {};
$buoop.ol = window.onload;

window.menuHasUpped = false;

window.onload = function() {
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

        menus[i].onclick = function() {
            var id = this.id;
            if (!this.className.match(".*visited.*")) {

                var menu = $('#' + id);
                var menus = $('.menuLink');
                for (var i = 0; i < menus.length; i++) {
                    $(menus[i]).removeClass("visited");
                }
                menu.addClass("visited");
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
    //makeSubMenu();
    //showSubMenu();
};

//Função para manter os menus 'colados' no topo da página
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
        divMenu.css('top', '-2px');
        var divContent = $(".content");
        divContent.css('padding-top', '0px');
    }
};


function hideSubMenu(time) {
    if (time === null) {
        time = 350;
    }
    var height = $('.subMenu menu').height();
    var subMenu = $(".subMenu");
    subMenu.animate({
        top: (-1) * height,
        opacity: 0.0
    }, time);

}

function showSubMenu() {
    var subMenu = $(".subMenu");
    subMenu.animate({
        top: "0px",
        opacity: 1
    }, 350);
}

function makeSubMenu(originMenu) {
    var menuName;
    if (originMenu != null) {
        menuName = originMenu.id;
    } else {
        menuName = "homeLink";
    }

    var subMenus;
    //Esse trecho deve ser feito se possível com ajax, para separar a lógica de negócio da camada de visão
    var controlador = "";
    switch (menuName) {
        case "homeLink":
            subMenus = new Array(
                    'Home->http://reuel.com.br', 'Link alternativos->localhost',
                    'Link 3->#', 'Link 4->#');
            break;
        case "usuariosLink":
            controlador = "usuario";
            subMenus = new Array(
                    'Inserir novo usuário->index.php?c=' + controlador + '&a=novo',
                    'Gerenciar usuários->index.php?c=' + controlador + '&a=gerenciar');
            break;
        case "cursosLink":
            controlador = "cursos";
            subMenus = new Array(
                    'Inserir novo registro->index.php?c=' + controlador + '&a=novo',
                    'Gerenciar registros->index.php?c=' + controlador + '&a=gerenciar');
            break;
        case "livrosLink":
            controlador = "livro";
            subMenus = new Array(
                    'Inserri novo registro->index.php?c=' + controlador + '&a=novo',
                    'Gerenciar registros->index.php?c=' + controlador + '&a=gerenciar',
                    'Registrar saída->index.php?c=' + controlador + '&a=saida',
                    'Registrar retorno->index.php?c=' + controlador + '&a=retorno',
                    'Gerar relatórios->index.php?c=' + controlador + '&a=relatorios');
            break;
        case "equipamentosLink":
            controlador = "equipamento";
            subMenus = new Array(
                    'Novo registro->index.php?c=' + controlador + '&a=novo',
                    'Gerenciar registros->index.php?c=' + controlador + '&a=gerenciar',
                    'Registrar saída->index.php?c=' + controlador + '&a=saida',
                    'Registrar retorno->index.php?c=' + controlador + '&a=retorno',
                    'Consultar registros->index.php?c=' + controlador + '&a=consulta');
            break;
        case "documentosLink":
            controlador = "documentos";
            subMenus = new Array(
                    'Gerar ofício->index.php?c=' + controlador + '&a=gerarOficio',
                    'Gerar relatório->index.php?c=' + controlador + '&a=gerarRelatorio',
                    'Gerenciar histórico->index.php?c=' + controlador + '&a=historico');
            break;
        case "viagensLink":
            controlador = "viagens";
            subMenus = new Array(
                    'Inserir nova viagem->index.php?c=' + controlador + '&a=nova',
                    'Gerenciar viagens->index.php?c=' + controlador + '&a=gerenciar');
            break;
    }
    var subMenuContainer = $('.subMenu menu');
    var linkName, link, htmlStruct = "";
    subMenuContainer.empty();
    for (var i = 0; i < subMenus.length; i++) {
        linkName = subMenus[i].split("->")[0].trim();
        link = subMenus[i].split("->")[1].trim();
        htmlStruct += '<a href="javascript:void(0)" onclick="ajax(\'' + link + '\');"><li>' + linkName + '</li></a>';
    }
    htmlStruct += '<a  id="hideSubMenu" onclick="hideSubMenu();"><li class="visited"><img alt="Esconder sub-menu" src="publico/images/icons/go-up.png"></li></a>';

    subMenuContainer.append(htmlStruct);
}