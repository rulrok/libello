
var $buoop = {};
$buoop.ol = window.onload;

window.menuHasUpped = false;

window.onload = function() {
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
                showSubMenu();
            }
        };
    }
    makeSubMenu();
    showSubMenu();
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
        divMenu.css('position', 'fixed');
        divMenu.css('top', '0px');
        divMenu.css('width', '100%');

        var divContent = $(".content");
        divContent.css('padding-top', '100px');
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
        top: (-1) * height
    }, time);
}

function showSubMenu() {
    var subMenu = $(".subMenu");
    subMenu.animate({
        top: "0px"
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
    switch (menuName) {
        case "homeLink":
            subMenus = new Array('Home->http://reuel.com.br', 'Link alternativos->localhost','Link 3->#','Link 4->#');
            break;
        case "usuariosLink":
            subMenus = new Array('Usuarios->http://reuel.com.br', 'Link alternativos->localhost');
            break;
        case "cursosLink":
            subMenus = new Array('cursos->http://reuel.com.br', 'Link alternativos->localhost');
            break;
        case "livrosLink":
            subMenus = new Array('livros->http://reuel.com.br', 'Link alternativos->localhost');
            break;
        case "equipamentosLink":
            subMenus = new Array('equipamentos->http://reuel.com.br', 'Link alternativos->localhost');
            break;
        case "documentosLink":
            subMenus = new Array('documentos->http://reuel.com.br', 'Link alternativos->localhost');
            break;
        case "viagensLink":
            subMenus = new Array('viagens->http://reuel.com.br', 'Link alternativos->localhost');
            break;
    }
    var subMenuContainer = $('.subMenu menu');
    var linkName, link, htmlStruct = "";
    subMenuContainer.empty();
    for (var i = 0; i < subMenus.length; i++) {
        linkName = subMenus[i].split("->")[0];
        link = subMenus[i].split("->")[1];
        htmlStruct += '<a href="' + link + '"><li>' + linkName + '</li></a>';
    }
    htmlStruct += '<a id="hideSubMenu" onclick="hideSubMenu();"><li class="visited"><img alt="Esconder sub-menu" src="publico/images/icons/go-up.png"></li></a>';

    subMenuContainer.append(htmlStruct);
}