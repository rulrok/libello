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
                <div class="input-append">
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
                        <li>Filtrar por usuário&nbsp;</li>
                        <li>
                            <select id="usuarios" class="ignorar" data-placeholder="Escolha um usuário">
                                <?php echo $this->todosUsuarios; ?>
                            </select>
                        </li>
                    </ul>
                </div><!-- /.nav-collapse -->
            </div>
        </div><!-- /navbar-inner -->
    </div>

    <div id="resultados"></div>
</div>
<script>

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

        itensPorPagina = $("#qtdItensPorPagina").val();

        paginaAtual = pagina;
//        ajax('index.php?c=imagens&a=buscar&l=' + itensPorPagina + '&p=' + pagina + '&q=' + $("#campo_busca").val(), '#resultados', false);
        var url = 'index.php?c=imagens&a=buscar&l=' + itensPorPagina + '&p=' + pagina + '&q=' + $("#campo_busca").val();
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

        $("#usuarios").chosen({allow_single_deselect: true});
        buscar(); //Exibe todas as imagens
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
            minLength: 4
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
    });

</script>