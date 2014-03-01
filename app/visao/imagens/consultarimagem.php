<center>
    <div class="input-append centralizado">
        <input name="busca" id="busca" placeholder="Buscar..." type="text" class="ignorar search-query input-xxlarge">
        <!--<button type="submit" class="btn">Search</button>-->
    </div>
</center>

<div id="resultados"></div>
<script>
    $(document).ready(function() {
        ajax('index.php?c=imagens&a=busca&q=' + $(this).val(), '#resultados', false);
        $("#busca").on('keyup', function(key) {
            ajax('index.php?c=imagens&a=busca&q=' + $(this).val(), '#resultados', false);
        });
    });

</script>