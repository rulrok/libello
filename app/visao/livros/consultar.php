<title>Consultar livros</title>
<!-- Início da página -->
<ul class="nav nav-tabs" id="abas">
    <li><a href="javascript:void(0)" onclick="carregarAjax('index.php?c=livros&a=consultar_interno', {recipiente: '#resultado_consulta', async: false});" data-toggle="tab">Interno</a></li>
    <li><a href="javascript:void(0)" onclick="carregarAjax('index.php?c=livros&a=consultar_externo', {recipiente: '#resultado_consulta', async: false});" data-toggle="tab">Externo</a></li>
    <li><a href="javascript:void(0)" onclick="carregarAjax('index.php?c=livros&a=consultar_embaixa', {recipiente: '#resultado_consulta', async: false});" data-toggle="tab">Baixa</a></li>
</ul>
<div id="resultado_consulta">

</div>
<?php
if (isset($_GET['l'])) {
    $local = $_GET['l'];
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
    $(document).ready(function () {

        $('#abas a').on('click', function () {
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
            history.replaceState(null, null, "#!livros|consultar&l=" + local)
        });
        var i = <?php echo $local; ?>;
        var local;
        //Script necessário para as abas
        var aba = $('#abas a')[i];
        $(aba).tab('show');
        $(aba).click();

    });
</script>