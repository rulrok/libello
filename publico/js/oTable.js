function configurarTabela(json) {


    var idTabela = json['idTabela'];
    var acaoDeletar = json['deletar'];
    var acaoEditar = json['editar'];
    var acaoAdicionar = json['adicionar'];

    var selectedElement;
    var oTable = $("#" + idTabela).dataTable({
        "aaSorting": [[1, "asc"]]
    });

    function habilitarBotoes() {
        $('.btn-deletar').removeClass('disabled');
        $('.btn-deletar').attr('disabled', false);
        $('.btn-editar').removeClass('disabled');
        $('.btn-editar').attr('disabled', false);
    }

    function desabilitarBotoes() {
        $('.btn-deletar').addClass('disabled');
        $('.btn-deletar').attr('disabled', true);
        $('.btn-editar').addClass('disabled');
        $('.btn-editar').attr('disabled', true);
    }

    function selecionarPrimeiraLinha() {

        var primeiraLinha = $("#" + idTabela + " tr")[1];
        if (!$(primeiraLinha.children[0]).hasClass("dataTables_empty")) {
            selectedElement = primeiraLinha;
            $(primeiraLinha).addClass('row_selected');
            habilitarBotoes();
        } else {
            desabilitarBotoes();
        }
    }

    selecionarPrimeiraLinha();

    $('input[aria-controls="' + idTabela + '"]').on('keyup', function() {
        if ($('.row_selected').size() == 0) {
            desabilitarBotoes();
        } else {
            habilitarBotoes();
        }
    });

    oTable.$('tr').mousedown(function(e) {
        oTable.$('tr.row_selected').removeClass('row_selected');
        $(this).addClass('row_selected');
        $('.btn-deletar').removeClass('disabled');
        $('.btn-deletar').attr('disabled', false);
        $('.btn-editar').removeClass('disabled');
        $('.btn-editar').attr('disabled', false);
        selectedElement = this;
    });

    $(".btn-adicionar").on('click', function() {
        ajax(acaoAdicionar);
    });
    $(".btn-editar").on('mousedown', function() {
        if ($('.row_selected').size() == 0) {
            return false;
        }
        var id = $("tr.row_selected>.campoID").html();
        ajax(acaoEditar + id);
    });

    $(".btn-deletar").on('click', function() {
        if ($('.row_selected').size() == 0) {
            return false;
        }
        if (confirm('Deseja realmente fazer isso?')) {
            var id = $("tr.row_selected>.campoID").html();
            ajax(acaoDeletar + id, "nenhum");
            var pos = oTable.fnGetPosition(selectedElement);
            oTable.fnDeleteRow(pos);
            $("tr.odd")[0].addClass("row_selected");
        }
    });

    $(".visualizarPermissoes").on('click', function() {
        var id = $("tr.row_selected>.campoID").html();
        $("#myModal").load("index.php?c=usuario&a=consultarpermissoes&userID=" + id).modal();

    });
}