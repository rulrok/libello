/*
 * Função que configura a classe do botões das páginas de gerência para dar a 
 * aparência de botões habilitado
 * 
 * @returns {undefined}
 */
function habilitarBotoes() {
    $('.btn-deletar').removeClass('disabled');
    $('.btn-deletar').prop('disabled', false);
    $('.btn-editar').removeClass('disabled');
    $('.btn-editar').prop('disabled', false);
    $('.btn-baixa').removeClass('disabled');
    $('.btn-baixa').prop('disabled', false);
    $('.btn-saida').removeClass('disabled');
    $('.btn-saida').prop('disabled', false);
    $('.btn-retorno').removeClass('disabled');
    $('.btn-retorno').prop('disabled', false);
    $('.btn-ativar').removeClass('disabled');
    $('.btn-ativar').prop('disabled', false);
}


//TODO padronizar nome de classe de butões para tornar essa função genérica para
//todas as página que possuem botões de ação. O problema de classes com o nome btn
//é que o bootstrap faz uso de classes com esses nomes

/*
 * Função que configura a classe do botões das páginas de gerência para dar a 
 * aparência de botões desabilitados
 * 
 * @returns {undefined}
 */
function desabilitarBotoes() {
    $('.btn-deletar').addClass('disabled');
    $('.btn-deletar').prop('disabled', true);
    $('.btn-editar').addClass('disabled');
    $('.btn-editar').prop('disabled', true);
    $('.btn-baixa').addClass('disabled');
    $('.btn-baixa').prop('disabled', true);
    $('.btn-saida').addClass('disabled');
    $('.btn-saida').prop('disabled', true);
    $('.btn-retorno').addClass('disabled');
    $('.btn-retorno').prop('disabled', true);
    $('.btn-ativar').removeClass('disabled');
    $('.btn-ativar').prop('disabled', true);
}

/*
 * Seleciona a primeira linha de uma jTable baseado no id da tabela
 * 
 * @param string idTabela
 * @returns {selecionarPrimeiraLinha.primeiraLinha}
 */
function selecionarPrimeiraLinha(idTabela) {

    $('.row_selected').removeClass('row_selected');
    var primeiraLinha = $("#" + idTabela + " tr")[1];
    if (primeiraLinha !== undefined) {
        if (!$(primeiraLinha.children[0]).hasClass("dataTables_empty")) {
            var selectedElement = primeiraLinha;
            $(primeiraLinha).addClass('row_selected');
            habilitarBotoes();
        } else {
            desabilitarBotoes();
        }
    } else {
        desabilitarBotoes();
    }
    return selectedElement;
}
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
    var acaoAtivar = parametros['ativar'];
    var definicoesTabela = parametros['defs'];

    if (definicoesTabela === undefined) {
        definicoesTabela = {
            "aaSorting": [[1, "desc"]],
            "aoColumnDefs": [{"bSearchable": false, "aTargets": [0]}]
        };
    }

    var acaoTabelaComDetalhes = false;
    var alvosTabelaComDetalhe;
    if (parametros['detalhes'] === undefined) {
        acaoTabelaComDetalhes = false;
    } else {
        acaoTabelaComDetalhes = true;
        alvosTabelaComDetalhe = parametros['detalhesIndice'];
    }

    var selectedElement;

    var oTable;
    if (acaoTabelaComDetalhes) {
        function fnFormatDetails(oTable, nTr)
        {
            var aData = oTable.fnGetData(nTr);
            var sOut = '<table class="tabelaDeDetalhes centralizado">';
            sOut += '<tr><td><b>Descrição:</b></td><td>' + aData[alvosTabelaComDetalhe] + '</td></tr>';

            sOut += '</table>';

            return sOut;
        }

        var nCloneTh = document.createElement('th');
        var nCloneTd = document.createElement('td');
        nCloneTh.innerHTML = "Desc.";
        nCloneTd.innerHTML = '<img src="publico/imagens/details_open.png" alt="Exibir detalhes">';
        nCloneTd.className = "center";

        $('#' + idTabela + ' thead tr').each(function () {
            this.insertBefore(nCloneTh, this.childNodes[0]);
        });

        $('#' + idTabela + ' tbody tr').each(function () {
            this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
        });

        oTable = $("#" + idTabela).dataTable(definicoesTabela);

        /* Add event listener for opening and closing details
         * Note that the indicator for showing which row is open is not controlled by DataTables,
         * rather it is done here
         */
        $('#' + idTabela + ' tbody td img').on('click', function () {
//            console.log($(this).parents('tr')[0])
            var nTr = $(this).parents('tr')[0];
            if (oTable.fnIsOpen(nTr))
            {
                /* This row is already open - close it */
                this.src = "publico/imagens/details_open.png";
                oTable.fnClose(nTr);
            }
            else
            {
                /* Open this row */
                this.src = "publico/imagens/details_close.png";
                oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
            }
        });

        //Duplo clique para abrir as descrições
        oTable.$('tr').dblclick(function () {
            console.log()
            var nTr = $(this)[0];
            var imagem = $($(this).children('td')[0]).children('img')[0];
            if (oTable.fnIsOpen(nTr)) {
                /* This row is already open - close it */
                imagem.src = "publico/imagens/details_open.png";
                oTable.fnClose(nTr);
            }
            else {
                /* Open this row */
                imagem.src = "publico/imagens/details_close.png";
                oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
            }
        });
    } else {
        oTable = $("#" + idTabela).dataTable(
                definicoesTabela
//                {
//            "aaSorting": [[1, "desc"]],
//            "aoColumnDefs": [{"bSearchable": false, "aTargets": [0, 5]}]
//        }
                );
    }
    $(window).bind('resize', function () {
        try {
            oTable.fnAdjustColumnSizing();
        } catch (e) {

        }
    });

//TODO
//Future fix for SAFARI
//    var bVis = oTable.fnSettings().aoColumns[0].bVisible;
//    oTable.fnSetColumnVis(0, bVis ? false : true);
//    $(oTable.dataTable().fnSettings().aoData).each(function(index) {
//        if (this.nTr.outerHTML.lastIndexOf("row_selected") != -1) {
//            alert(this._aData[1]);
//        }
//        console.log(this.nTr.outerHTML);
//    });


    selectedElement = selecionarPrimeiraLinha(idTabela);

    var delay = function () {
        configurarBusca(idTabela);
    };
    setTimeout(delay, 1000);

    function configurarBusca(id) {
        var aux = $("#" + id + "_wrapper input[aria-controls]");
        $(aux).on('keyup', function () {
            selectedElement = selecionarPrimeiraLinha(id);
        });

    }

    oTable.$('tr').mousedown(function (e) {
        oTable.$('tr.row_selected').removeClass('row_selected');
        $(this).addClass('row_selected');
        habilitarBotoes();
        selectedElement = this;
    });


    $(".btn-deletar").on('click', function () {
        if ($('.row_selected').size() == 0) {
            return false;
        }
        if (confirm('Deseja realmente fazer isso?')) {
            var id = $("tr.row_selected>.campoID").html();

            $.ajax({
                url: acaoDeletar + id
                , success: function () {
                    var status = obterStatusOperacao()
                    if (status == Mensagem.prototype.Tipo.SUCESSO) {
                        var pos = oTable.fnGetPosition(selectedElement);
                        oTable.fnDeleteRow(pos);
                        $($("tr.odd")[0]).addClass(function () {
                            var $this = $(this.children[0]);
                            if (!$this.hasClass("dataTables_empty")) {
                                return "row_selected";
                            } else {
                                desabilitarBotoes();
                            }
                        });
                    }
                }
            });
        }
    });

    $(".btn-ativar").on('click', function () {
        if ($('.row_selected').size() == 0) {
            return false;
        }
        if (confirm('Deseja realmente fazer isso?')) {
            var id = $("tr.row_selected>.campoID").html();
            $.ajax({
                url: acaoAtivar + id
                , success: function () {
                    var status = obterStatusOperacao()
                    if (status == Mensagem.prototype.Tipo.SUCESSO) {
                        var pos = oTable.fnGetPosition(selectedElement);
                        oTable.fnDeleteRow(pos);
                        $($("tr.odd")[0]).addClass(function () {
                            var $this = $(this.children[0]);
                            if (!$this.hasClass("dataTables_empty")) {
                                return "row_selected";
                            } else {
                                desabilitarBotoes();
                            }
                        });
                    }
                }
            });

        }
    });

    $(".btn-editar").on('mousedown', function () {
        if ($('.row_selected').size() == 0) {
            return false;
        }
        var id = $("tr.row_selected>.campoID").html();
        carregarPagina(acaoEditar + id);
    });

    $(".visualizarPermissoes").on('click', function () {
        var id = $("tr.row_selected>.campoID").html();
        $("#myModal").load("index.php?c=usuarios&a=consultarpermissoes&userID=" + id).modal();

    });

    $(".btn-saida").on('click', function () {
        if ($('.row_selected').size() == 0) {
            return false;
        }
        var id = $("tr.row_selected>.campoID").html();
        carregarPagina(acaoSaida + id);
    });

    $(".btn-retorno").on('click', function () {
        if ($('.row_selected').size() == 0) {
            return false;
        }
        var id = $("tr.row_selected>.campoID").html();
        carregarPagina(acaoRetorno + id);
    });

    $(".btn-baixa").on('click', function () {
        if ($('.row_selected').size() == 0) {
            return false;
        }
        var id = $("tr.row_selected>.campoID").html();
        carregarPagina(acaoBaixa + id);
    });


}