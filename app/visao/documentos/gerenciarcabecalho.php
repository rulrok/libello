<title>Gerenciar Cabeçalho</title>
<style>
    small{
        font-size: 12px;
        color:#666;
    }
</style>



<div style="text-align: center;" >
    <form name="formulario" id="ajaxForm" class="tabela centralizado" enctype="multipart/form-data" action="index.php?c=documentos&a=verificarnovocabecalho" method="POST">
        
        <!--<form name="ajaxForm" id="ajaxForm" class="tabela centralizado"  enctype="multipart/form-data" action="" method="POST">-->
        <fieldset>
            <legend>Cabeçalho Atual:</legend>
            <!--"microtime" força o navegador a puxar a imagem sem uso do cache-->
            <img style="border: 1px solid #ddd;" id="imagem" src="publico/imagens/cabecalho-documentos/cabecalho.jpg?<?php echo microtime(); ?>" alt="cabeçalho"/>
            <hr>
            <a id="texto"> Escolha um novo cabeçalho:</a>
            <br>
            <small style="color:red">Imagem no formado .jpeg e de proporcionalidade 580x90 pixels</small> 
            <br>
            <br>
            <input id="image-upload" class="btn btn-small btn-info campoVarrido" type="file" name="image-upload" accept="image/jpeg,image/jpg" required="" />
        </fieldset>
        <button id="btn_enviar" class="btn btn-large btn-success btn-right" disabled="" value="enviar" >Enviar</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $("[type=file]").on('change', function() {
            $('#btn_enviar').removeAttr('disabled');
        });

        $("form[name='formulario']").submit(function(e) {
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "index.php?c=documentos&a=verificarnovocabecalho",
                type: "POST",
                data: formData,
                async: false,
                success: function(msg) {
                    d = new Date();
                    $("#imagem").attr("src", "publico/imagens/cabecalho-documentos/cabecalho.jpg?" + d.getTime());
                },
                cache: false,
                contentType: false,
                processData: false
            });
            e.preventDefault();
        });
    });


</script>