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
        $("#b_submit").click();

    });

}

function capturaNumMemorando() {

    $.getJSON('index.php?c=documentos&a=capturarNumDocumento', {valor: 2}, function(j) {
        $('#i_numMemorando').val(j);
        $("#b_submit").click();

    });
}

function pad(d) {
    return (d < 10) ? '0' + d.toString() : d.toString();
}



function Form() {
    this.assinaturasCount = 1;
    this.campoAssinatura = {0: '<div class="remetente_div" >' +
                '<p>______________________________________</p>' +
                '<div style="padding-left: 152px;margin-bottom: 2px">' +
                '<input type="text" required id="remetente',  1: '"value="',2:   '" onkeyup="liberarCadastro()" size="50" /><span class="classeExemploOficio"> Ex: Prof. Dr. Gabriel G... </span>' +
                '</div>' +
                '<div style="padding-left: 193px;">' +
                '<input type="text" required id="cargo_remetente',  3: '"value="',4:  '" onkeyup="liberarCadastro()" size="25" /><span class="classeExemploOficio"> Ex: Coordenador CEAD</span>' +
                '<a title="Adicionar Remetente" id=""  onclick="adicionarRemetente();" class="btn" href="javascript:void(0);" ><i class="icon-plus"></i></a>' +
                '</div>' +
                '</div>'};
}

Form.prototype.formaCampoDeAssinatura = function(i, j,k) {
    if(j == undefined)
        j= '';
    if(k == undefined){
        k='';
    }
    return this.campoAssinatura[0] + i + this.campoAssinatura[1] + j + this.campoAssinatura[2]+i+this.campoAssinatura[3]+k+this.campoAssinatura[4];
};

Form.prototype.iniciarRemetentes = function() {
    if ($('#remetente').val() == '' && $('#cargo_remetente').val() == '') {

        $('#remetentes_holder').append(this.formaCampoDeAssinatura(this.assinaturasCount));
        this.assinaturasCount++;

    } else {
        var remetentes = $('#remetente').val().split(';');
        var cargos_remetentes = $('#cargo_remetente').val().split(';');
        var numAsn = remetentes.lenght > cargos_remetentes.lenght ? remetentes.lenght : cargos_remetentes.lenght;
        for (var i = this.assinaturasCount ; i <= numAsn; i++,this.assinaturasCount++) {
            $('#remetentes_holder').append(this.formaCampoDeAssinatura(i,remetentes[i-1],cargos_remetentes[i-1]));
        }
    }
};

Form.prototype.diaMesDocumento = function(mesatual) {

    var mes = new Array;

    var date = new Date();

    mes[0] = '#janeiro';
    mes[1] = '#fevereiro';
    mes[2] = '#marco';
    mes[3] = '#abril';
    mes[4] = '#maio';
    mes[5] = '#junho';
    mes[6] = '#julho';
    mes[7] = '#agosto';
    mes[8] = '#setembro';
    mes[9] = '#outubro';
    mes[10] = '#novembro';
    mes[11] = '#dezembro';

    $('#mes ' + mes[mesatual]).attr({selected: true});

    var numDias = new Date(date.getFullYear(), (mesatual + 1) % 12, 0).getDate();
    $('#dia').empty();

    for (var i = 1; i <= numDias; i++) {
        $('#dia').append('<option value="' + pad(i) + '" >' + pad(i) + '</option>');
    }

    if (mesatual == date.getMonth()) {
        $('[value=' + date.getDate() + ']').attr({selected: true});
    }


};

Form.prototype.iniciarCombo = function() {
    var d = new Date();
    this.diaMesDocumento(d.getMonth());
    $('#mes').on('change', function() {
        diaMesDocumento($('#mes ').val() - 1);
    });
};

Form.prototype.iniciarEditorDeTexto = function() {
    tinymce.init({selector: 'textarea',
        toolbar: "forecolor backcolor",
        tools: 'inserttable',
        skin: 'lightgray',
        plugins: 'contextmenu advlist directionality charmap preview visualblocks image table textcolor spellchecker link',
        contextmenu: "link image inserttable | cell row column deletetable | forecolor backcolor"
    });
};

Form.prototype.acaoReset = function() {
    $('.reset').on('click', function() {
        setTimeout(function() {


            liberarCadastro();

        }, 50);
    });
};

Form.prototype.liberarBotoes = function() {
    $('#ajaxForm *').on('keyup', function() {
        liberarCadastro();
    });
};

Form.prototype.posicaoMenu = function() {
    var documento_form = $('#documento_form');
    var posicao_doc = documento_form.position();
    var menu = $('#menu_documento');

    $('#menu_documento').css({left: (posicao_doc.left) + 'px', top: (posicao_doc.top + 300) + 'px'});
    $('#corpo').on('change', function() {
        $('#corpo').val('_');
    });
};



Form.prototype.iniciarForm = function() {
    this.iniciarCombo();
    this.iniciarEditorDeTexto();
    this.acaoReset();
    this.liberarBotoes();
    this.posicaoMenu();
    this.iniciarRemetentes();
};


