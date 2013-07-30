/*
 * Esse script varre os campos que são marcados como requeridos e trata eles com
 * base na propriedade 'name' dos campos para verificálos.
 * Apenas insíra-o no HTML e certifique-se dos nomes dos campos 'name' serem
 * compatíveis.
 */
var camposObrigatorios = $("input[required],select[required]");
if (camposObrigatorios.length > 0) {
//document.head.children[document.head.children.length] = "<script src=\"publico/js/validarCampos.js\"></script>";
    //$("head").append("<script src=\"publico/js/validarCampos.js\"></script>");
    for (i = 0; i < camposObrigatorios.length; i++) {
        $(camposObrigatorios[i]).after("<img src=\"publico/imagens/icones/campo_obrigatorio.png\">");
        //$(camposObrigatorios[i]).on('blur',liberarCadastro());
        //$(camposObrigatorios[i]).append(liberarCadastro());
    }
    $("input[required],select[required]").on('change', function() {
        liberarCadastro()
    });
    $('input').not("input[required],select[required]").on('change', function() {
        $("input[type=submit],input[value~='Atualizar']").attr('disabled', false);
    });

    $('input[readonly]').on('blur', function() {
        $("input[type=submit],input[value~='Atualizar']").attr('disabled', false);
    });
}

/**
 * A função varre todos os campos obrigatório, e com base na propriedade 'name' dos componenetes,
 * ela decide qual a validação utilizada para o campo, como por exemplo, se são apenas letras,
 * números e etc; essa validação é feita através de uma expressão regular.
 * Para comboboxes, a única validação é que o primeiro elemento não pode estár selecionado
 * (opções como "-- Escolha uma opção --" que são valores padrões. Para esses casos, o campo 'name'
 * desses componentes deve começar obrigatoriamente com a palavra 'cb_';
 * Se nenhuma regra de nome for casada, a opção padrão de validação será selecionada, que no caso,
 * apenas exige que o campo contenha qualquer tipo de caracter.
 * @returns {undefined}
 */
function liberarCadastro() {
    var campos = $("input[required],select[required]");
    var patter = null;
    var senhaLida = "";
    var tudoCerto = true;
    var todosEmBranco = true;
    var letrasacentuadas = "a-zA-ZÀ-ú";
    var letras = "a-zA-Z";
    var letrasnumeros = letras + "0-9";


    for (var i = 0; i < campos.length; i++) {

        var nome = campos[i].name;
        if (campos[i].type == "select-one") {
            nome = "combobox";
        }
        switch (nome) {
            case "nome":
                patter = new RegExp("^[" + letrasacentuadas + "]+ *$");
                break;
            case "nomecurso":
            case "nomepolo":
                patter = new RegExp("^[" + letrasacentuadas + " -]{1,30}[" + letrasacentuadas + "-] *$");
                break;
            case "sobrenome":
                //Padrão: Apenas letras e espaços
                patter = new RegExp("^[" + letrasacentuadas + " ]{1,30}[" + letrasacentuadas + "] *$");
                break;
            case "login":
                //Apenas letras minúsculas, com no mínimo 3
                patter = new RegExp("^[a-z]{3,}$");
                break;
                //Validação básica de email
            case "email":
                patter = new RegExp("[" + letrasnumeros + "_.]+@[" + letrasnumeros + "]+(\\.[" + letras + "-]+)+");
                break;
            case "senha":
                //Qualquer palavra sem espaço, com no mínimo 6 caracteres
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
            case "combobox":
                //Rejeita campos com o valor 'default' (uma ER que NEGA uma palavra)
                patter = new RegExp("^((?!default).)*$");
                break;
            default:
                patter = new RegExp(".+");
                break;
        }

        //window.alert("Vai testar: " + campos[i].value+"\nPattern: "+patter);
        if (campos[i].value != "") {
            todosEmBranco = false;
        }

        if (!patter.test(campos[i].value)) {
            tudoCerto = false;
            $(campos[i]).addClass("campoErrado");
            //break;
        } else {
            $(campos[i]).removeClass("campoErrado");
            //window.alert("Campo correto: "+campos[i].value );
        }
    }

    if (todosEmBranco) {
        $(".campoErrado").removeClass("campoErrado");
    }
    if (tudoCerto) {
        $("input[type=submit],input[value~='Atualizar']").attr('disabled', false);

    } else {
        $("input[type=submit],input[value~='Atualizar']").attr('disabled', true);
    }
}