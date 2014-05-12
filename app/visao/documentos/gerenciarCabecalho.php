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
            <img style="border: 1px solid #ddd;" src="publico/imagens/cabecalho-documentos/cabecalho.jpg" alt="cabeçalho"/>
            <hr>
            alterar cabeçalho(<small>580x90</small>): <input id="image-upload" class="btn btn-small btn-info campoVarrido" type="file" name="image-upload" accept="image/jpeg,image/jpg" required="" />
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
});
</script>