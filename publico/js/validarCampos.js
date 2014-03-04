/**
 * Quando novos campos são dinamicamente adicionados a algum formulário, esse método deve ser execultado
 * para atribuir a esses novos campos, as verificações necessárias, como quando um deles perde o foco ou
 * tem seu conteúdo alterado.
 * 
 */
function varrerCampos() {
    var camposObrigatorios = $("input:required,select:required,textarea:required").not(".ignorar").not(".campoVarrido");
    if (camposObrigatorios.length > 0) {
        $(camposObrigatorios).each(function() {

            $(this).after('<img class="imagemCampoObrigatorio" src="publico/imagens/icones/campo_obrigatorio.png" alt="Campo obrigatório">');
            $(this).addClass("campoVarrido");
//            $(this).bind('keyup', liberarCadastro);
            var tempoDigitando;                //timer identifier
            var intervaloDigitacao = 500;  //time in ms, 5 second for example


            $(this).bind("keyup", function() {
                clearTimeout(tempoDigitando);
                if ($(this).val != "") {
                    tempoDigitando = setTimeout(liberarCadastro, intervaloDigitacao);
                }
            });

//            $(this).keyup(function() {
//                tempoDigitando = setTimeout(liberarCadastro, intervaloDigitacao);
//            });
//
//            $(this).keydown(function() {
//                clearTimeout(tempoDigitando);
//            });


            $(this).bind('change', liberarCadastro);
        });

        $("input[type=reset]").bind('mouseup', function() {
            setTimeout(liberarCadastro, "300")
        });

        $("input[type=submit]").bind("mouseover", liberarCadastro);
    }
    trataCamposData();
    var camposComuns = $("input:not(:required),select:not(:required),textarea:not(:required)").not("[hidden],[type=submit],[type=reset]");
    $(camposComuns).bind("blur", liberarCadastro);
}

/**
 * Função especialmente feita para tratar os campos de data, para quando o usuário escolhe uma data e sai do campo.
 * Ela foi necessária, pois a função onchange não é ativada por causa do campo estar
 * definido como readonly e a inserção da data no campo pelo javascript não ativava a função.
 * 
 * @returns {undefined}
 */
function trataCamposData() {
    var camposData = $(".campoData").not(".ignorar");

    $(camposData).on("mousedown", function(e) {
        $(document).on("mouseup", function() {
            setTimeout(liberarCadastro, 300);
        });
    });
}

/**
 * A função varre todos os campos obrigatório, e com base na propriedade 'name' dos componenetes,
 * ela decide qual a validação utilizada para o campo, como por exemplo, se são apenas letras,
 * números e etc; essa validação é feita através de uma expressão regular.
 * Para comboboxes, a única validação é que o primeiro elemento não pode estar selecionado
 * (opções como "-- Escolha uma opção --" que são valores padrões. Para esses casos, o campo 'name'
 * desses componentes deve começar obrigatoriamente com a palavra 'cb_';
 * Se nenhuma regra de nome for casada, a opção padrão de validação será selecionada, que no caso,
 * apenas exige que o campo não esteja vazio.
 * 
 * @author Reuel 
 * 
 * @returns {undefined}
 */
function liberarCadastro() {
    $("input[type=submit]").prop('disabled', true);
    var campos = $("input:required,select:required,textarea:required").not(".ignorar");
    var patter = null;
    var senhaLida = "";
    var tudoCerto = true;
    var todosEmBranco = true;
    var letrasacentuadas = "a-zA-ZÀ-ú";
    var letras = "a-zA-Z";
    var letrasnumeros = letras + "0-9";
    //setup before functions



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
            case "quantidade":
            case "quantidadePatrimonios":
                patter = new RegExp("(^[1-9]([0-9]*)?)");
                campos[i].value = campos[i].value.replace(campos[i].value.match("^0*"), ""); //Elimina 0s a esquerda.
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
                //Rejeita campos com o valor 'default'
                patter = new RegExp("^((?!default).)*$");
                break;
            case "diarias": //Página de cadastro de viagens
                patter = new RegExp("(?!^0$)^[0-9]+?(\.[05])?$");
                break;
            case "cpf":
            case "cpfautor":
                patter = new RegExp("[0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2}");
                if (!patter.test(campos[i].value)) {
                    tudoCerto = false;
                    $(campos[i]).addClass("campoErrado");
                } else {
                    if (validarCPF(campos[i].value)) {
                        $(campos[i]).removeClass("campoErrado");
                    } else {
                        tudoCerto = false;
                        $(campos[i]).addClass("campoErrado");
                    }
                }
                continue;
            case "ano":
                patter = new RegExp("^[0-9]{3,4}$");
                break;
            default:
                patter = new RegExp(".+");
                break;
        }

        //window.alert("Vai testar: " + campos[i].value+"\nPattern: "+patter);
//        if (nome != "combobox") {
        if (campos[i].value != "" && campos[i].value != "default") {
            todosEmBranco = false;
        }
//        } else {
//            if (campos[i].value != "default") {
//                todosEmBranco = false;
//            }
//        }

        if (!patter.test(campos[i].value)) {
//            console.log(campos[i])
            tudoCerto = false;
            $(campos[i]).addClass("campoErrado");
//            break;
        } else {
            $(campos[i]).removeClass("campoErrado");
            //window.alert("Campo correto: "+campos[i].value );
        }
    }

    if (todosEmBranco) {
        $(".campoErrado").removeClass("campoErrado");
        document.paginaAlterada = false;
        tudoCerto = false;
    }
    if (tudoCerto) {
        $("button[type=submit]").prop('disabled', false);
    } else {
        $("button[type=submit]").prop('disabled', true);
    }
}

function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf == '')
        return false; // Elimina CPFs invalidos conhecidos
//    if (cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999")
//        return false; // Valida 1o digito 
    add = 0;
    for (i = 0; i < 9; i ++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false; // Valida 2o digito 
    add = 0;
    for (i = 0; i < 10; i ++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;
    return true;
}
