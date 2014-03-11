function liberarCadastro() {
    var inputs = $('input[type!=hidden]');
    var podeGerar = false;
//    var conteudo = tinymce.get('corpo').getContent();
    var conteudo = $('#corpo').text();
    for (var i = 0; i < inputs.length; i++) {
        if ($(inputs.get(i)).val() == '') {
            podeGerar = false;
            break;
        } else {
            podeGerar = true;
        }
    }
    if (conteudo == '') {
        podeGerar = false;
    }
    $('#b_gerar').attr({disabled: !podeGerar});

    if ($('#assunto').val() != '') {
        $('#b_salvar').removeAttr('disabled');
    } else {
        $('#b_salvar').attr({disabled: 'true'});
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

function concatenarAssinaturas() {
    var remetentes = $('.remetente');
    var cargos_remetentes = $('.cargo_remetente');
    var string_remetente = '', string_cargo_remetente = '';

    for (var i = 0; i < remetentes.length; i++) {
        if (i > 0) {
            string_remetente += ';';
            string_cargo_remetente += ';';
        }
        if ($(remetentes.get(i)).val() == '') {
            string_remetente += ' ';
        } else {
            string_remetente += $(remetentes.get(i)).val();
        }
        if ($(cargos_remetentes.get(i)).val() == '') {
            string_cargo_remetente += ' ';
        } else {
            string_cargo_remetente += $(cargos_remetentes.get(i)).val();
        }
    }
    $('#remetente').val(string_remetente);
    $('#cargo_remetente').val(string_cargo_remetente);
}
;

function capturaNumOficio() {
    concatenarAssinaturas();
    $.getJSON('index.php?c=documentos&a=capturarNumDocumento', {valor: 1}, function(j) {
        $('#i_numOficio').val(j);
        $("#b_submit").click();

    });

}

function capturaNumMemorando() {
    concatenarAssinaturas();

    $.getJSON('index.php?c=documentos&a=capturarNumDocumento', {valor: 2}, function(j) {
        $('#i_numMemorando').val(j);
        $("#b_submit").click();

    });
}

function pad(d) {
    return (d < 10) ? '0' + d.toString() : d.toString();
}



function Form() {
    // this.assinaturasCount = 1;
    //this.instancia = new Form();
    this.campoAssinatura = {0: '<div class="remetente_div" id="assinatura-', 1: '" >' +
                '<p>______________________________________</p>' +
                '<div style="padding-left: 152px;margin-bottom: 2px">' +
                '<input type="text" required class="remetente" value="', 2: '" onkeyup="liberarCadastro()" size="50" /><span class="classeExemploOficio"> Ex: Prof. Dr. Gabriel G... </span>' +
                '</div>' +
                '<div style="padding-left: 152px;">' +
                '<input type="text" required class="cargo_remetente" value="', 3: '" onkeyup="liberarCadastro()" size="25" /><span class="classeExemploOficio"> Ex: Coordenador CEAD</span>' +
                '</div><div><button type="button" title="Adicionar Remetente"  onclick="Form.instancia.adicionarRemetente();"  class="btn btn-add-rmt" ><i class="icon-plus"></i></button>' +
                '<button type="button"  title="Remover Remetente" disabled  onclick="Form.instancia.removerRemetente(', 4: ');" class="btn btn-remove-rmt" ><i class="icon-minus"></i></button>' +
                '</div>' +
                '</div>'};
}

Form.instancia = new Form();

Form.assinaturasCount = 1;

Form.prototype.adicionarRemetente = function() {

    $('#remetentes_holder').append(this.formaCampoDeAssinatura(Form.assinaturasCount++));
    var asn_count = $('.remetente_div').length;
    if (asn_count > 1) {
        $('.btn-remove-rmt').removeAttr('disabled');
    }
    liberarCadastro();
};
Form.prototype.removerRemetente = function(i) {
    $('#assinatura-' + i).remove();
    var asn_count = $('.remetente_div').length;
    if (asn_count == 1) {
        $('.btn-remove-rmt').attr({disabled: true});
    }

};

Form.prototype.formaCampoDeAssinatura = function(i, j, k) {
    if (j == undefined)
        j = '';
    if (k == undefined) {
        k = '';
    }
    return this.campoAssinatura[0] + i + this.campoAssinatura[1] + j + this.campoAssinatura[2] + k + this.campoAssinatura[3] + i + this.campoAssinatura[4];
};

Form.prototype.iniciarRemetentes = function() {
    if ($('#remetente').val() == '' && $('#cargo_remetente').val() == '') {
        $('#remetentes_holder').append(this.formaCampoDeAssinatura(Form.assinaturasCount));
        Form.assinaturasCount++;

    } else {
        var remetentes = $('#remetente').val().split(';');
        var cargos_remetentes = $('#cargo_remetente').val().split(';');

        var numAsn = remetentes.length > cargos_remetentes.lenght ? remetentes.length : cargos_remetentes.length;
        for (var i = Form.assinaturasCount; i <= numAsn; i++, Form.assinaturasCount++) {
            $('#remetentes_holder').append(this.formaCampoDeAssinatura(i, remetentes[i - 1], cargos_remetentes[i - 1]));
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
        $('#dia [value=' + pad(date.getDate()) + ']').attr({selected: true});
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
    $('textarea').tinymce({
        // Location of TinyMCE script
        setup:function(ed){
            ed.on('change keyup',function(){
                liberarCadastro() ;
            });
        },
        toolbar: "forecolor backcolor",
        tools: 'inserttable',
        skin: 'lightgray',
        plugins: 'contextmenu advlist directionality charmap preview visualblocks image table textcolor spellchecker link',
        contextmenu: "link image inserttable | cell row column deletetable | forecolor backcolor"
                // General options
//                        theme : "advanced",
//                        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
//
//                        // Theme options
//                        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
//                        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
//                        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
//                        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
//                        theme_advanced_toolbar_location : "top",
//                        theme_advanced_toolbar_align : "left",
//                        theme_advanced_statusbar_location : "bottom",
//                        theme_advanced_resizing : true,
//
//                        // Example content CSS (should be your site CSS)
//                        content_css : "css/content.css",
//
//                        // Drop lists for link/image/media/template dialogs
//                        template_external_list_url : "lists/template_list.js",
//                        external_link_list_url : "lists/link_list.js",
//                        external_image_list_url : "lists/image_list.js",
//                        media_external_list_url : "lists/media_list.js",
//
//                        // Replace values for the template plugin
//                        template_replace_values : {
//                                username : "Some User",
//                                staffid : "991234"

    });

//    tinymce.init({selector: 'textarea',
//        toolbar: "forecolor backcolor",
//        tools: 'inserttable',
//        skin: 'lightgray',
//        plugins: 'contextmenu advlist directionality charmap preview visualblocks image table textcolor spellchecker link',
//        contextmenu: "link image inserttable | cell row column deletetable | forecolor backcolor"
//    });
};

Form.prototype.acaoReset = function() {
    $('.reset').on('click', function() {
        setTimeout(function() {


            liberarCadastro();

        }, 50);
    });
};

Form.prototype.liberarBotoes = function() {
    $('input[type!=hidden]').on('keyup change', function() {
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


