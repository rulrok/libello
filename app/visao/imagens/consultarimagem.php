

<div id="resultadoImagens">

          <!--<input autofocus autocomplete class="ignorar search-query input-xlarge" name="busca" id="campo_busca" placeholder="Buscar..." type="text">-->

    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <!--<a class="brand" href="#">Title</a>-->
                <div class="nav-collapse collapse navbar-responsive-collapse">
                    <div class="input-append">
                        <input type="text" autofocus autocomplete="off" class="ignorar input-xxlarge" name="busca" id="campo_busca" placeholder="Procure pelo título ou pelo nome do descritor..." data-provide="typeahead" style="position: relative; top: 6px;">
                        <button id="botao_limpar" class="btn" type="button" data-toggle="Limpar" title="Limpar campo de busca" style="position: relative; top: 6px;"><i class="icon-remove"></i></button>
                        <button id="botao_buscar_imagem" class="btn" type="button" style="position: relative; top: 6px;">Procurar</button>
                    </div>
                    <ul class="nav pull-right">
                        <li class="divider-vertical"></li>
                        <li >
                            <span style="position: relative; top: 6px;">Itens por página 
                                <select id="qtdItensPorPagina" class="ignorar">
                                    <option value="1">1</option>
                                    <option value="5">5</option>
                                    <option value="10" selected>10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </span>
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
        ajax('index.php?c=imagens&a=buscar&l=' + itensPorPagina + '&p=' + pagina + '&q=' + $("#campo_busca").val(), '#resultados', false);
    }
    function extractor(query) {
        var result = /([^,]+)$/.exec(query);
        if (result && result[1])
            return result[1].trim();
        return '';
    }
    $(document).ready(function() {
        buscar(); //Exibe todas as imagens
        $("#botao_buscar_imagem").on('click', function() {
            buscar();
        });
        $("#botao_limpar").tooltip({placement: 'bottom'});
        $("#botao_limpar").on('click', function() {
            $('#campo_busca').val('');
            buscar();
        });
        $('#campo_busca').typeahead({
            minLength: 4
            , source: function(query, process) {
                $.ajax({
                    url: 'index.php?c=imagens&a=obterDescritores',
                    type: 'POST',
                    dataType: 'JSON',
                    data: 'query=' + extractor(query),
                    success: function(data) {
                        console.log(data);
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
//                    clearTimeout(timeoutBuscaId);
//                    timeoutBuscaId = setTimeout(function() {
//                        buscar();
//                    }, 300);
                    break;
            }


        });
    });

</script>