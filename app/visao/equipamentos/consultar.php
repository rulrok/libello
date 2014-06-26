<title>Consultar equipamentos</title>
<!-- Início da página -->
<ul class="nav nav-tabs" id="abas">
    <li><a href="javascript:void(0)" onclick="ajax('index.php?c=equipamentos&a=consultar_interno', '#resultado_consulta', false);" data-toggle="tab">Interno</a></li>
    <li><a href="javascript:void(0)" onclick="ajax('index.php?c=equipamentos&a=consultar_externo', '#resultado_consulta', false);" data-toggle="tab">Externo</a></li>
    <li><a href="javascript:void(0)" onclick="ajax('index.php?c=equipamentos&a=consultar_embaixa', '#resultado_consulta', false);" data-toggle="tab">Baixa</a></li>
</ul>
<div id="resultado_consulta">

</div>
<?php
if (filter_has_var(INPUT_GET, 'l')) {
    $local = filter_input(INPUT_GET, 'l');
    switch ($local) {
        case "baixa":
            $local = 2;
            break;
        case "externo":
            $local = 1;
            break;
        case "interno":
            $local = 0;
            break;
        default :
            $local = 0;
    }
} else {
    $local = 0;
}
?>
<script id="pos_script">
    $(document).ready(function() {

        $('#abas a').on('click', function() {
            switch (this.innerHTML.toLowerCase()) {
                case "interno":
                    local = "interno";
                    break;
                case "externo":
                    local = "externo";
                    break;
                case "baixa":
                    local = "baixa";
                    break;
                default:
                    local = "interno";
            }
            history.replaceState(null, null, "#!equipamentos|consultar&l=" + local);
        });
        var i = <?php echo $local; ?>;
        var local;
        //Script necessário para as abas
        var aba = $('#abas a')[i];
        $(aba).tab('show');
        $(aba).click();

    });
</script>