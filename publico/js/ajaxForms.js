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
 * @param {Function} successFn Função para ser ativada com um evento de sucesso. Será  a última ação executada após o sucesso.
 * @param {Function} alwaysFn Função que sempre será executada.
 * @param {boolean} resetarFormulario Indica se o formulário deve ser resetado após a conclusão com sucesso.
 */
function formularioAjax(idFormulario, recipient, completeFn, successFn, alwaysFn, resetarFormulario) {


    if (typeof idFormulario == "object") {
        recipient = idFormulario['recipient'];
        completeFn = idFormulario['completeFn'];
        successFn = idFormulario['successFn'];
        alwaysFn = idFormulario['alwaysFn'];
        resetarFormulario = idFormulario['resetarFormulario'];
        idFormulario = idFormulario['idFormulario'];
    }

    if (resetarFormulario === undefined) {
        resetarFormulario = true;
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


    function _preProcessar(formData, jqForm, options) {
        //Retornando FALSE através dessa função, o envio do formulário será cancelado
        //Qualquer outra coisa deixará o formulário ser enviado
        $("input[type=submit],button[type=submit]").attr('disabled', true);
        return true;
    }

    function _posProcessar(formData, jfForm, options) {
        $("input[type=submit],button[type=submit]").attr('disabled', true);
        if (completeFn !== undefined && isFunction(completeFn)) {
            completeFn();
        }
        $("input[type=submit],button[type=submit]").attr('disabled', true);
    }

    function _sucesso(responseText, statusText, xhr, $form) {
        // for normal html responses, the first argument to the success callback 
        // is the XMLHttpRequest object's responseText property 

        // if the ajaxSubmit method was passed an Options Object with the dataType 
        // property set to 'xml' then the first argument to the success callback 
        // is the XMLHttpRequest object's responseXML property 

        // if the ajaxSubmit method was passed an Options Object with the dataType 
        // property set to 'json' then the first argument to the success callback 
        // is the json data object returned by the server 

        var status = obterStatusOperacao()
        if (status == Mensagem.prototype.Tipo.SUCESSO) {
            document.paginaAlterada = false;
            if (successFn !== undefined && isFunction(successFn)) {
                successFn();
            }
            if (resetarFormulario) {
                $("input[type=reset],button[type=reset]").click();
            }
        }
    }


    var opcoes = {
        target: recipient // target element(s) to be updated with server response 
        , beforeSubmit: _preProcessar // pre-submit callback 
        , success: _sucesso  // post-submit callback 
        , complete: _posProcessar
        , aways: alwaysFn
        , url: $("#" + idFormulario).prop("action")         // override for form's 'action' attribute 
        , type: $("#" + idFormulario).prop("method")        // 'get' or 'post', override for form's 'method' attribute 
//        , dataType: 'json'        // 'xml', 'script', or 'json' (expected server response type) 
        , clearForm: false      // clear all form fields after successful submit 
        , resetForm: false      // reset the form after successful submit 
    };

    $("#" + idFormulario).submit(function (e) {

        $(this).ajaxSubmit(opcoes);

        //Important. Stop the normal POST
        e.preventDefault();
        return false;
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
    $(botao).on("mouseup", function () {
        $(this).prop("enabled", false);
    });
}