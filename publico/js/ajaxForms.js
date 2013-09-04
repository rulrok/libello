/*
 * Esse javascript se encarrega de tratar os formulários <form> que são enviados.
 */
// wait for the DOM to be loaded 
$(document).ready(function() {
    $("#ajaxForm").submit(function(e) {
        //Do the AJAX post
        $.post($("#ajaxForm").attr("action"), $("#ajaxForm").serialize(), function(data) {

            if (data !== null && data != "undefined") {
                data = extrairJSON(data);

                if (data.status != "undefined" && data.mensagem != "undefined") {
                    showPopUp(data.mensagem, data.status);
                    if (data.status.toLowerCase() === "sucesso") {
                        $("input[type=reset]").click();
                    }
                } else {
                    showPopUp("Houve algum problema na resposta do servidor.", "erro");
                }
            } else {
                showPopUp("Houve algum problema na resposta do servidor.", "erro");
            }
        });
        //Important. Stop the normal POST
        document.paginaAlterada = false;
        e.preventDefault();
    });
});