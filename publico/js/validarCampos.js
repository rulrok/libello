
var camposObrigatorios = $(".campoObrigatorio");
if (camposObrigatorios.length > 0) {
//document.head.children[document.head.children.length] = "<script src=\"publico/js/validarCampos.js\"></script>";
    //$("head").append("<script src=\"publico/js/validarCampos.js\"></script>");
    for (i = 0; i < camposObrigatorios.length; i++) {
        $(camposObrigatorios[i]).after("<img src=\"publico/images/icons/campo_obrigatorio.png\">");
        //$(camposObrigatorios[i]).on('blur',liberarCadastro());
        //$(camposObrigatorios[i]).append(liberarCadastro());
    }
    $(".campoObrigatorio").on('change', function() {
        liberarCadastro()
    });
    $('input').not(".campoObrigatorio").on('change', function() {
        $("input[type=submit],input[value~='Atualizar']").attr('disabled', false);
    });

    $('input[readonly]').on('blur', function() {
        $("input[type=submit],input[value~='Atualizar']").attr('disabled', false);
    });
}

function liberarCadastro() {
    var campos = $(".campoObrigatorio");
    var patter;
    var senhaLida = "";
    var tudoCerto = true;

    for (var i = 0; i < campos.length; i++) {

        switch (campos[i].name) {
            case "nome":
                patter = new RegExp("^[a-zA-Z]+ *$");
                break;
            case "sobrenome":
                patter = new RegExp("^[a-zA-Z ]{1,30}[a-zA-Z] *$");
                break;
            case "login":
                patter = new RegExp("^[a-z]{3,}$");
                break;
            case "email":
                patter = new RegExp(".*@.*");
                break;
            case "senha":
                patter = new RegExp("[^ ]{6,}");
                if (senhaLida === "") {
                    senhaLida = campos[i].value;
                } else {
                    if (senhaLida === campos[i].value) {
                        $(campos[i]).removeClass("campoErrado");
                        continue;
                    } else {
                        $(campos[i]).addClass("campoErrado");
                        tudoCerto = false;
                        continue;
                    }
                }
                break;
            case "confsenha":
                if (senhaLida == "") {
                    senhaLida = campos[i].value;
                } else {
                    if (senhaLida == campos[i].value) {
                        $(campos[i]).removeClass("campoErrado");
                        continue;
                    } else {
                        $(campos[i]).addClass("campoErrado");
                        tudoCerto = false;
                        continue;
                    }
                }
                break;
            case "senhaAtual":
                patter = new RegExp(".{3,}");
                break;
            case "papel":
                //patter = new RegExp("([1-9]{1,1}[0-9]*|[0]*[1-9]+)");
                patter = new RegExp("^((?!default).)*$");
                break;
        }

        //window.alert("Vai testar: " + campos[i].value+"\nPattern: "+patter);
        if (!patter.test(campos[i].value)) {
            tudoCerto = false;
            $(campos[i]).addClass("campoErrado");
            //break;
        } else {
            $(campos[i]).removeClass("campoErrado");
            //window.alert("Campo correto: "+campos[i].value );
        }
    }
    if (tudoCerto) {
        $("input[type=submit],input[value~='Atualizar']").attr('disabled', false);

    } else {
        $("input[type=submit],input[value~='Atualizar']").attr('disabled', true);
    }
}