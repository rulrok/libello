<title>Buscar imagem</title>
<br/>
<div id="resultadoImagens" class="blocoBranco">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <!--<a class="brand" href="#"></a>-->
                <span><i class="icon-picture"></i></span>
                <span class="divider-vertical"></span>
                <div class="input-append" style="position: relative; top: 4px;">
                    <input type="text" autofocus autocomplete="off" class="ignorar input-xxlarge fix_position search-query" name="busca" id="campo_busca" placeholder="Procure pelo título ou pelo nome do descritor..." data-provide="typeahead">
                    <button id="botao_buscar_imagem" class="fix_position btn-buscainterna" type="button" ><i class="icon-search"></i></button>
                    <button id="botao_limpar" class="fix_position btn-buscainterna" type="button" data-toggle="Limpar" title="Limpar campo de busca" ><i class="icon-remove"></i></button>
                </div>
                <span class="pull-right">
                    <button id="b_filtros" class="btn" title="Filtros">
                        <i id="mostrar_filtros" class="icon-chevron-down hidden"></i>
                        <i id="ocultar_filtros" class="icon-chevron-up "></i>
                    </button>
                </span>
                <div id="barra_filtros" class="nav-collapse collapse navbar-responsive-collapse" >
                    <ul class="nav fix_position pull-left">
                        <li>
                            Exibir&nbsp;
                        </li>
                        <li >
                            <select id="qtdItensPorPagina" class="ignorar">
                                <option value="10">10</option>
                                <option value="20" selected>20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </li>
                        <li>
                            &nbsp;imagens
                        </li>

                    </ul>
                    <span class="divider-vertical pull-left"></span>
                    <ul class="nav fix_position  pull-left">
                        <!--<li class="divider-vertical"></li>-->
                        <!--<li>Período&nbsp;</li>-->
                        <li>
                            <span id="reportrange" class="btn" style="display: inline-block; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; margin: 0">
                                <i class="icon-calendar"></i>
                                <span><?php setlocale(LC_ALL, 'pt_BR'); echo date("j/M/Y", strtotime('-30 day')); ?> - <?php echo date("j/M/Y"); ?></span> <b class="caret"></b>
                            </span>
                        </li>
                    </ul>
                    <span class="divider-vertical pull-left"></span>
                    <?php if ($this->acessoTotal) : ?>
                        <ul class="nav fix_position  pull-left">
                            <!--<li class="divider-vertical"></li>-->
                            <li>Autor&nbsp;</li>
                            <li>
                                <select id="usuarios" class="ignorar" data-placeholder="Escolha um usuário">
                                    <?php echo $this->todosUsuarios; ?>
                                </select>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div><!-- /.nav-collapse -->
            </div>
        </div><!-- /navbar-inner -->
    </div>

    <div id="resultados"></div>
</div>
<script>

    config_datepicker = {
        startDate: moment().subtract('days', 29),
        endDate: moment(),
        minDate: '01/01/2000',
        maxDate: '12/31/2014',
        dateLimit: {days: 60},
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: false,
        ranges: {
            'Todos os dias': [moment().subtract('years', 14), moment()],
            'Hoje': [moment(), moment()],
            'Ontem': [moment().subtract('days', 1), moment().subtract('days', 1)],
            'Últimos 7 dias': [moment().subtract('days', 6), moment()],
            'Últimos 30 dias': [moment().subtract('days', 29), moment()],
            'Esse mês': [moment().startOf('month'), moment().endOf('month')],
            'Mês passado': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
        },
        opens: 'right',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'DD/MM/YYYY',
        separator: '/',
        locale: {
            applyLabel: 'Aplicar',
            cancelLabel: 'Cancelar',
            fromLabel: 'De',
            toLabel: 'Até',
            weekLabel: 'S',
            customRangeLabel: 'Personalizar',
            daysOfWeek: ["Seg", "Ter", "Qua", "Qui", "Sex", "Sab", "Dom"],
            monthNames: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            firstDay: 0
        }
    };

    $('#reportrange').daterangepicker(config_datepicker, function(start, end) {
        $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
    });

    paginaAtual = 1;
    //==========================================================================
    //  Função que recupera o texto digitado no campo de busca e carrega a consulta
    //por ajax e exibe os resultados na página.
    //  Aceita a página desejada como parâmetro. Caso a página seja inválida, o
    //  valor 1 será usado por padrão.
    //  A quantidade de itens por página é obtido automaticamente do componente
    //  da página.
    //==========================================================================
    function buscar(pagina) {
        if (pagina === undefined) {
            pagina = 1;
        } else {
            try {
                pagina = parseInt(pagina);
            } catch (e) {
                pagina = 1;
            }
        }

        var itensPorPagina = $("#qtdItensPorPagina").val();
        var termos = ($("#campo_busca").val()).split(',');
        var consulta = "";
        //Fase de normalização dos termos de busca para uma string padronizada
        for (var i = 0; i < termos.length; i++) {
            consulta += termos[i].replace(/ +/g, ' ').replace(/^ +/, '').replace(/ +$/, '') + ',';
        }
        consulta = consulta.replace(/,$/, '');
        consulta = encodeURI(consulta);
        var usuario = $("#usuarios").val();

        paginaAtual = pagina;

        var url = 'index.php?c=imagens&a=buscar&l=' + itensPorPagina + '&p=' + pagina + '&q=' + consulta;
        if (usuario !== undefined) {
            url = url + '&u=' + usuario;
        }
        $("#resultados").load(url);
    }

    function extractor(query) {
        var result = /([^,]+)$/.exec(query);
        if (result && result[1])
            return result[1].trim();
        return '';
    }

    $(document).ready(function() {

        $("#qtdItensPorPagina").chosen({
            disable_search_threshold: 10
        });

        if ($("#usuarios").length) { //Verifica se o componente está sendo exibido
            $("#usuarios").chosen({allow_single_deselect: true});
            $("#usuarios").on('change', function() {
                buscar();
            });
        }

        $("#botao_buscar_imagem").on('click', function() {
            buscar();
        });

        $("#b_filtros").tooltip({placement: 'top'});
        $("#b_filtros").on('click', function() {
            $("#barra_filtros").fadeToggle("fast", function() {

                $("#ocultar_filtros").toggleClass("hidden");
                $("#mostrar_filtros").toggleClass("hidden");
            });
        });

        $("#botao_limpar").tooltip({placement: 'top'});
        $("#botao_limpar").on('click', function() {
            $('#campo_busca').val('');
            buscar();
        });

        //Configura o campo para aceitar multiplas sugestões de descritores, separados por virgula
        //Originalmente o componente não mostra outro depois de já haver algum selecionado.
        $('#campo_busca').typeahead({
            minLength: 2
            , source: function(query, process) {
                $.ajax({
                    url: 'index.php?c=imagens&a=obterDescritores',
                    type: 'POST',
                    dataType: 'JSON',
                    data: 'query=' + extractor(query),
                    success: function(data) {
                        process(data);
                    }
                });
            }
            , updater: function(item) {
                return this.$element.val().replace(/[^,]*$/, '') + item + ',';
            }
            , matcher: function(item) {
                var tquery = extractor(this.query);
                if (!tquery)
                    return false;
                return ~item.toLowerCase().indexOf(tquery.toLowerCase());
            }
            , highlighter: function(item) {
                var query = extractor(this.query).replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&');
                return item.replace(new RegExp('(' + query + ')', 'ig'), function($1, match) {
                    return '<strong>' + match + '</strong>';
                });
            }
        });

        var to = false;
        $("#campo_busca").on('keyup', function(e) {
            switch (e.keyCode) {
                case 13: // enter
                    //                    clearTimeout(timeoutBuscaId);
                    buscar();
                    break;
                case 9: // tab
                    e.preventDefault();
                    break
                case 27: // escape
                    $("#campo_busca").val("");
                    buscar();
                    break
                case 38: // up arrow
                    e.preventDefault();
                    break

                case 40: // down arrow
                    e.preventDefault();
                    break
                default :
                    if (to) {
                        clearTimeout(to);
                    }
                    to = setTimeout(function() {
                        buscar();
                    }, 400);
                    break;
            }


        });

        buscar(); //Exibe todas as imagens
    });

</script>