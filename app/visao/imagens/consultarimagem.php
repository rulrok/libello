<center>
    <div class="input-append centralizado">
        <input autofocus autocomplete name="busca" id="campo_busca" placeholder="Buscar..." type="text" class="ignorar search-query input-xxlarge">
        <!--<button type="submit" class="btn">Search</button>-->
    </div>
</center>

<div id="resultados"></div>
<script>
    function buscar(pagina) {
        if (pagina === undefined) {
            pagina = 1;
        }
        ajax('index.php?c=imagens&a=busca&p=' + pagina + '&q=' + $("#campo_busca").val(), '#resultados', false);
    }
    $(document).ready(function() {
        buscar(); //Exibe todas as imagens
        var timeoutBuscaId;
        $("#campo_busca").on('keydown', function(key) {
            if (key.keyCode === 13) {
                clearTimeout(timeoutBuscaId);
                buscar();
            } else {
                clearTimeout(timeoutBuscaId);
                timeoutBuscaId = setTimeout(function() {
                    buscar();
                }, 300);
            }

        });
    });

</script>