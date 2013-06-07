/*
 * Esse javascript se encarrega de tratar os formulários <form> que são enviados.
 */
// wait for the DOM to be loaded 
$(document).ready(function() {
    var options = {
        target: '.contentWrap', //Área de conteúdo principal
//        beforeSend: function() {
//            $(".contentWrap").empty();
//        }
    };
    // bind 'myForm' and provide a simple callback function 
    $('#ajaxForm').submit(function() {
        $(this).ajaxSubmit(options);
        document.paginaAlterada = false;
        return false;
    });
});