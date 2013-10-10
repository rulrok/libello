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
 */
function formularioAjax(idFormulario, recipient, completeFn, successFn) {

    if (idFormulario === undefined) {
        idFormulario = $("form").prop("id");
        if (idFormulario === undefined) {
            return;
        }
    }
    $("#" + idFormulario).submit(function(e) {
        //Do the AJAX post
        var post = $.post($("#" + idFormulario).attr("action"), $("#" + idFormulario).serialize(), function(data) {
            if (data !== null && data !== undefined) {
                data = extrairJSON(data);

                if (data.status !== undefined && data.mensagem !== undefined) {
                    showPopUp(data.mensagem, data.status);
                    if (data.status.toLowerCase() === "sucesso") {
                        $("input[type=reset]").click();
                        if (successFn !== undefined && isFunction(successFn)) {
                            successFn();
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
        //Important. Stop the normal POST
        e.preventDefault();
    });
}

function isFunction(functionToCheck) {
    var getType = {};
    return functionToCheck && getType.toString.call(functionToCheck) === '[object Function]';
}