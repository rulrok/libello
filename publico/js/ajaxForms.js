// wait for the DOM to be loaded 
$(document).ready(function() {
    var options = {
        target: '.contentWrap',
//        beforeSend: function() {
//            $(".contentWrap").empty();
//        }
    };
    // bind 'myForm' and provide a simple callback function 
    $('#ajaxForm').submit(function() {
        $(this).ajaxSubmit(options);
        return false;
    });
});