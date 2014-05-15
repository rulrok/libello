<title>Gerenciar Cabeçalho</title>
<style>
    small{
        font-size: 12px;
        color:#666;
    }
</style>



<div style="text-align: center;" >
    <form id="ajaxForm" class="tabela centralizado"  enctype="multipart/form-data" action="index.php?c=documentos&a=verificarnovocabecalho" method="POST">
        <fieldset>
            <legend>Cabeçalho Atual:</legend>
            <!--"microtime" força o navegador a puxar a imagem sem uso do cache-->
            <img style="border: 1px solid #ddd;" id="imagem" src="publico/imagens/cabecalho-documentos/cabecalho.jpg?<?php echo microtime();?>" alt="cabeçalho"/>
            <hr>
            <a id="texto"> Escolha um Novo Cabeçalho(<small>Imagem no formado .jpeg e de dimensão 580x90</small>): </a>
            <br>
            <br>
            <input id="image-upload" class="btn btn-small btn-info campoVarrido" type="file" name="image-upload" accept="image/jpeg,image/jpg" required="" />
        </fieldset>
        <button id="btn_enviar" class="btn btn-large btn-success btn-right" disabled="" value="enviar" >Enviar</button>
    </form>
</div>

<script>
$(document).ready(function(){
    $("[type=file]").on('change',function(){
        $('#btn_enviar').removeAttr('disabled');
    });
    formularioAjax();
    
    //Atualiza a imagem após o submit
    $("#ajaxForm").submit(function() {
        d = new Date();
        //a passagem extra de parâmetro neste caso, força o navegador a "Atualizar" o cache
        $("#imagem").attr("src", "publico/imagens/cabecalho-documentos/cabecalho.jpg?"+d.getTime());
    });
});

</script>