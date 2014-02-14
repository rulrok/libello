<div class="btn-group" data-toggle="buttons-radio" id="abas">
    <a href="javascript:void(0);" class="btn ignorar"
       id="b_categorias" 
       onclick="ajax('index.php?c=imagens&a=gerenciarCategorias', '#resultado_consulta', false);" 
       >Categorias</a>
    <a href="javascript:void(0);" class="btn ignorar" 
       id="b_subcategorias" 
       onclick="ajax('index.php?c=imagens&a=gerenciarSubcategorias', '#resultado_consulta', false);" 
       >Subcategorias</a>
</div>
<div id="resultado_consulta"></div>
<?php
if (isset($_GET['l'])) {
    $local = $_GET['l'];
    switch ($local) {
        case "subcategorias":
            $local = 1;
            break;
        case "categorias":
            $local = 0;
            break;
        default :
            $local = 0;
    }
} else {
    $local = 0;
}
?>
<script>
           $(document).ready(function() {

               $('#abas a').on('click', function() {
                   switch (this.innerHTML.toLowerCase()) {
                       case "categorias":
                           local = "categorias";
                           break;
                       case "subcategorias":
                           local = "subcategorias";
                           break;
                       default:
                           local = "categorias";
                   }
                   history.replaceState(null, null, "#!imagens|categoriaseafins&l=" + local);
               });
               var i = <?php echo $local; ?>;
               var local;
               var aba = $('#abas a')[i];
               $(aba).click();

           });
</script>