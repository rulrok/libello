/**
 * Configura um formulário HTML para enviar seus dados via Ajax, sem ser necessário
 * que a página recarregue. 
 * Caso não seja especificado algum parâmetro, o script vai tentar buscar por algum
 * formulário que esteja presente na página, que possua um id obrigatoriamente,
 * e irá configurá-lo; caso exista mais de um formulário na página, nesse caso,
 * apenas o primeiro será configurado, caso não exista, o script vai retornar
 * sem alterar nada na página.
 * A ação deve estar especificada no campo action do formulário.
 * 
 * @author Reuel
 * 
 * @param {String} idFormulario O nome do id, sem "#"no início, do formulário.
 * @param {String} recipient Lugar onde a resposta será colocada. Caso <code>undefined</code>,
 * nada será alterado na página.
 * @param {Function} completeFn Função para ser ativada com o evento <code>complete</code>
 * do ajax.
 * @param {Function} successFn Função para ser ativada com um evento de sucesso.
 * @param {Function} alwaysFn Função que sempre será executada.
 */
function formularioAjax(idFormulario, recipient, completeFn, successFn, alwaysFn) {


    if (typeof idFormulario == "object") {
        recipient = idFormulario['recipient'];
        completeFn = idFormulario['completeFn'];
        successFn = idFormulario['successFn'];
        alwaysFn = idFormulario['alwaysFn'];
        idFormulario = idFormulario['idFormulario'];
    }



    if (idFormulario === undefined) {
        idFormulario = $("form").prop("id");
        if (idFormulario === undefined) {
            return;
        }
    }
    var aux = "#" + idFormulario + " button[type=submit]";
    var botaoAcao = $(aux);
    desabilitarBotaoAcao(botaoAcao);
    $("#" + idFormulario).submit(function(e) {
        //Do the AJAX post
        var post = $.post($("#" + idFormulario).attr("action"), $("#" + idFormulario).serialize(), function(data) {
            if (data !== null && data !== undefined) {
                console.log(data);
                data = extrairJSON(data);

                if (data.status !== undefined && data.mensagem !== undefined) {
                    showPopUp(data.mensagem, data.status);
                    if (data.status.toLowerCase() === "sucesso") {
                        $("input[type=reset],button[type=reset]").click();
                        if (successFn !== undefined && isFunction(successFn)) {
                            successFn(data);
                        }
                    }
                } else {
                    showPopUp("Houve algum problema na resposta do servidor.", "erro");
                }
            } else {
                showPopUp("Houve algum problema na resposta do servidor.", "erro");
            }

        });

        document.paginaAlterada = false;

        post.complete(function(data) {
            if (recipient !== undefined) {

                $(recipient).empty();
                $(recipient).html(data.responseText);
            }
            if (completeFn !== undefined && isFunction(completeFn)) {
                completeFn();
            }
        });

        post.always(function() {
            if (alwaysFn !== undefined && isFunction(alwaysFn)) {
                alwaysFn();
            }
        });
        //Important. Stop the normal POST
        e.preventDefault();
    });
}

function isFunction(functionToCheck) {
    var getType = {};
    return functionToCheck && getType.toString.call(functionToCheck) === '[object Function]';
}

/**
 * Desabilita um botão assim que ele é acionado para enviar um formulário, evitando 
 * que a pessoa mande duas vezes os mesmo formulário para o servidor.
 * 
 * @param {type} botao DOM do botão
 * @returns {undefined}
 */
function desabilitarBotaoAcao(botao) {
    $(botao).on("mouseup", function() {
        $(this).prop("enabled", false);
    });
}