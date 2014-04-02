<title>Gerenciar Cabeçalho</title>

<div style="text-align: center;" >
    <form class="tabela centralizado"  enctype="multipart/form-data" action="index.php?c=documentos&a=verificarnovocabecalho" method="POST">
        <fieldset>
            <legend>Cabeçalho Atual:</legend>
            <img style="border: 1px solid #ddd;" src="publico/imagens/cabecalho-documentos/cabecalho.jpg" alt="cabeçalho"/>
            <hr>
            alterar cabeçalho(<small>580x90</small>): <input id="image-upload" class="btn btn-small btn-info campoVarrido" type="file" name="image-upload" accept="image/jpeg,image/png,image/jpg" required="" />
        </fieldset>
        <button class="btn btn-large btn-success btn-right" disabled="" value="enviar" >Enviar</button>
    </form>
</div>
