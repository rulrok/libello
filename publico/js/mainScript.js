
var $buoop = {};
$buoop.ol = window.onload;
window.menuHasUpped = false;

window.onload = function() {
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
                if (!this.className.match(".*visited.*")) {

                    var menu = $('#homeLink');
                    var menus = $('.menuLink');
                    for (var i = 0; i < menus.length; i++) {
                        $(menus[i]).removeClass("visited");
                    }
                    menu.addClass("visited");
                }

                hideSubMenu(150);
            }
            continue;
        }
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

function showPopUp(data) {
    $(".popUpContent").empty();
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
    if (originMenu !== null) {
        menuName = originMenu.id;
    } else {
        menuName = "homeLink";
    }

    menuName = menuName.substring(0, menuName.lastIndexOf("Link"));
    menuName = menuName.concat("SubMenu");
    var subMenus = $(".subMenu menu ul");

    for (var i = 0; i < subMenus.length; i++) {

        subMenus[i].classList.add("hiddenSubMenuLink");

    }

    for (var i = 0; i < subMenus.length; i++) {
        if (subMenus[i].classList.contains(menuName)) {
            subMenus[i].classList.remove("hiddenSubMenuLink");
            break;
        }
    }
}

function ajax(link)
{
    $.ajax({
        url: link
    }).done(function(data) {
        $(".contentWrap").empty();
        $(".contentWrap").append(data);
        hidePopUp();
    });
}