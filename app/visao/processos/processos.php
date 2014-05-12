<div class="btn-group" data-toggle="buttons-radio" id="abas">
    <a href="javascript:void(0);" class="btn ignorar"
       id="b_gerenciar" 
       onclick="ajax('index.php?c=processos&a=caixaProcessos', '#resultado_consulta', false);" 
       >Gerenciar</a>
    <a href="javascript:void(0);" class="btn ignorar" 
       id="b_novo" 
       onclick="ajax('index.php?c=processos&a=novodescritor', '#resultado_consulta', false);" 
       >Cadastrar</a>
</div>
<br/>
<br/>
<br/>
<div id="resultado_consulta"></div>
<?php
if (isset($_GET['l'])) {
    $local = $_GET['l'];
    switch ($local) {
        case "cadastrar":
            $local = 1;
            break;
        case "gerenciar":
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
                case "gerenciar":
                    local = "gerenciar";
                    break;
                case "cadastrar":
                    local = "cadastrar";
                    break;
                default:
                    local = "gerenciar";
            }
            history.replaceState(null, null, "#!processos|descritores&l=" + local);
        });
        var i = <?php echo $local; ?>;
        var local;
        var aba = $('#abas a')[i];
        $(aba).click();

    });
</script>