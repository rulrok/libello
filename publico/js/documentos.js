 function liberarCadastro() {
        if ($('#assunto').val() != '') {
            $('#b_salvar').removeAttr('disabled');
        } else {
            $('#b_salvar').attr({disabled: 'true'});
        }
        if ($('#i_remetente').val() == "0") {
            if (($('#tratamento').val() != '') && ($('#destino').val() != '') && ($('#cargo_destino').val() != '') && ($('#assunto').val() != '') && ($('#referencia').val() != '') && ($('#tinymce').html() != '') && ($('#remetente').val() != '') && ($('#cargo_remetente').val() != '')) {
                $('#b_gerar').removeAttr('disabled');
            }
            else if (($('#tratamento').val() == '') || ($('#destino').val() == '') || ($('#cargo_destino').val() == '') || ($('#assunto').val() == '') || ($('#referencia').val() == '') || ($('#tinymce').html() == '') || ($('#remetente').val() == '') || ($('#cargo_remetente').val() == '')) {
                $('#b_gerar').attr({disabled: 'true'});
            }
        }
        else if ($('#i_remetente').val() == "1") {
            if (($('#tratamento').val() != '') && ($('#destino').val() != '') && ($('#cargo_destino').val() != '') && ($('#assunto').val() != '') && ($('#referencia').val() != '') && ($('#corpo').val() != '') && ($('#remetente').val() != '') && ($('#cargo_remetente').val() != '') && ($('#remetente2').val() != '') && ($('#cargo_remetente2').val() != '')) {
                $('#b_gerar').removeAttr('disabled');
            }
            else if (($('#tratamento').val() == '') || ($('#destino').val() == '') || ($('#cargo_destino').val() == '') || ($('#assunto').val() == '') || ($('#referencia').val() == '') || ($('#corpo').val() == '') || ($('#remetente').val() == '') || ($('#cargo_remetente').val() == '') || ($('#remetente2').val() == '') || ($('#cargo_remetente2').val() == '')) {
                $('#b_gerar').attr({disabled: 'true'});
            }
        }
    }
    
     function bloqueia() {
        $('#tratamento').attr({readonly: 'true'});
        $('#destino').attr({readonly: 'true'});
        $('#cargo_destino').attr({readonly: 'true'});
        $('#assunto').attr({readonly: 'true'});
        $('#referencia').attr({readonly: 'true'});
        $('#corpo').attr({readonly: 'true'});
        $('#remetente').attr({readonly: 'true'});
        $('#cargo_remetente').attr({readonly: 'true'});
        if ($('#i_remetente').val() == "1") {
            $('#remetente2').attr({readonly: 'true'});
            $('#cargo_remetente2').attr({readonly: 'true'});
        }
        $('#b_gerar').attr({readonly: 'true'});
        $('#b_salvar').attr({readonly: 'true'});
    }
    
    function desbloqueia() {
        $('#tratamento').removeAttr('readonly');
        $('#destino').removeAttr('readonly');
        $('#cargo_destino').removeAttr('readonly');
        $('#assunto').removeAttr('readonly');
        $('#referencia').removeAttr('readonly');
        $('#corpo').removeAttr('readonly');
        $('#remetente').removeAttr('readonly');
        $('#cargo_remetente').removeAttr('readonly');
        if ($('#i_remetente').val() == "0") {
            $('#remetente2').removeAttr('readonly');
            $('#cargo_remetente2').removeAttr('readonly');
        }
        $('#b_gerar').removeAttr('readonly');
        $('#b_salvar').removeAttr('readonly');
    }
    
     function adicionarRemetente() {
        $("#div_remetente2").show();
        $("#add_rem").hide();
        $("#i_remetente").val("1");
    }

    function removerRemetente() {
        $("#div_remetente2").hide();
        $("#add_rem").show();
        $("#i_remetente").val("0");
    }
    
    function capturaNumOficio() {
        $.getJSON('index.php?c=documentos&a=capturarNumDocumento', {valor: 1}, function(j) {
            $('#i_numOficio').val(j);
            $("#ajaxForm").submit();

        });

    }

function capturaNumMemorando() {
        
        $.getJSON('index.php?c=documentos&a=capturarNumDocumento', {valor: 2}, function(j) {
            $('#i_numMemorando').val(j);
            $("#ajaxForm").submit();
            
        });
    }