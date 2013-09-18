/**
 * Configura as tabelas das páginas de gerencia de coisas, como usuários, equipamentos e etc.
 * 
 * @author Reuel
 * 
 * @param {type} parametros
 * @returns {undefined}
 */
function configurarTabela(parametros) {


    var idTabela = parametros['idTabela'];
    var acaoDeletar = parametros['deletar'];
    var acaoEditar = parametros['editar'];
    var acaoBaixa = parametros['baixa'];
    var acaoSaida = parametros['saida'];
    var acaoRetorno = parametros['retorno'];

    var selectedElement;
    var oTable = $("#" + idTabela).dataTable({
        "aaSorting": [[1, "desc"]]
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

//    $(".btn-adicionar").on('click', function() {
//        ajax(acaoAdicionar);
//    });

    $(".btn-editar").on('mousedown', function() {
        if ($('.row_selected').size() == 0) {
            return false;
        }
        var id = $("tr.row_selected>.campoID").html();
        carregarPagina(acaoEditar + id);
    });

    $(".btn-deletar").on('click', function() {
        if ($('.row_selected').size() == 0) {
            return false;
        }
        if (confirm('Deseja realmente fazer isso?')) {
            var id = $("tr.row_selected>.campoID").html();
            var data = ajax(acaoDeletar + id, null, false, false);
            if (data !== null && data !== undefined) {
                data = extrairJSON(data);

                if (data.status !== undefined && data.mensagem !== undefined) {
                    showPopUp(data.mensagem, data.status);
                    if (data.status.toLowerCase() === "sucesso") {
                        $("input[type=reset]").click(); //Limpar o formulário depois de cadastrado com sucesso.
                    }
                } else {
                    showPopUp("Houve algum problema na resposta do servidor.", "erro");
                }
            } else {
                showPopUp("Houve algum problema na resposta do servidor.", "erro");
            }
            var pos = oTable.fnGetPosition(selectedElement);
            oTable.fnDeleteRow(pos);
            $("tr.odd")[0].addClass("row_selected");

        }
    });

    $(".visualizarPermissoes").on('click', function() {
        var id = $("tr.row_selected>.campoID").html();
        $("#myModal").load("index.php?c=usuarios&a=consultarpermissoes&userID=" + id).modal();

    });

    $(".btn-saida").on('click', function() {
        if ($('.row_selected').size() == 0) {
            return false;
        }
        var id = $("tr.row_selected>.campoID").html();
        carregarPagina(acaoSaida + id);
    });

    $(".btn-retorno").on('click', function() {
        if ($('.row_selected').size() == 0) {
            return false;
        }
        var id = $("tr.row_selected>.campoID").html();
        carregarPagina(acaoRetorno + id);
    });
    $(".btn-baixa").on('click', function() {
        if ($('.row_selected').size() == 0) {
            return false;
        }
        var id = $("tr.row_selected>.campoID").html();
        carregarPagina(acaoBaixa + id);
    });

    $(".btn-baixa").on('click', function() {
        if ($('.row_selected').size() == 0) {
            return false;
        }
        var id = $("tr.row_selected>.campoID").html();
    });
}