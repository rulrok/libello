<title>Nova imagem</title>
<!-- Início da página -->
<div id="showimg"> </div>

<form class="table centered" id="upload-image-form-ajax" method="post" action="index.php?c=imagens&a=verificarnovaimagem">
    <fieldset>
        <legend>Dados da imagem</legend>
        <p class="centered centeredText boldedText">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png"> são obrigatórios</label>
        <div class="line">
            <label for='nome'>Título</label>
            <input required type="text" id="nome" name="nome" class="input-xlarge" placeholder="Nome da imagem">
        </div>
        <div class="line">
            <label for="descricoes">Descrição geral</label>
            <textarea type="textarea" rows="8" id="descricoes" name="descricoes" class="input-xlarge" title="Descrições" data-content="Alguma característica do equipamento. Limite de 1000 caracteres." ></textarea>           
            <div id="chars">1000</div>
        </div>
        <div class="line">
            <label for='descritor1'>Descritor 1</label>
            <input required type="text" id="descritor1" name="descritor1" class="input-large" placeholder="Descritor 1">
        </div>
        <div class="line">
            <label for='descritor2'>Descritor 2</label>
            <input required type="text" id="descritor2" name="descritor2" class="input-large" placeholder="Descritor 2">
        </div>
        <div class="line">
            <label for='descritor3'>Descritor 3</label>
            <input required type="text" id="descritor3" name="descritor3" class="input-large" placeholder="Descritor 3">
        </div>
        <div class="line">
            <label for='categoria'>Categoria</label>
            <?php echo $this->comboBoxCategorias; ?>
        </div>
        <div class="line">
            <label for='subcategoria'>Sub-categoria</label>
            <span id="subcategorias_wrap">
                <select>
                    <option>-- Selecione uma categoria --</option>
                </select>
            </span>
        </div>
        <div class="line">
            <label for="dificuldade">Dificuldade</label>
            <select name="dificuldade" id="dificuldade">
                <option value="1">Fácil</option>
                <option value="2">Médio</option>
                <option value="3">Difícil</option>
            </select>
        </div>
        <br/>
    </fieldset>
    <fieldset>
        <legend>Imagem</legend>

        <div class="centered">
            <div class="line">
                <label for="raw-file-upload">Arquivo vetorizado da imagem</label>
                <input required type="file" size="40" name="raw-image-upload" id="raw-image-upload" class="btn btn-small btn-warning"> 
            </div>
            <div class="line">
                <label for="image-upload">Arquivo de imagem</label>
                <input required type="file" size="40" name="image-upload" id="image-upload" class="btn btn-small btn-warning"> 
            </div>
            <div id="image-info">
                <button id="remove-image-upload" style="display: none;">
                    <img src="publico/imagens/cross.png" /> Remover
                </button>



                <div id="resultado_imagem">
                    <ul class="thumbnails">
                        <li class="span4">
                            <img class="loading" alt="loading..." src="publico/imagens/loader.gif" style="display: none;">
                            <div class="thumbnail">
                                <img alt="picture" src="publico/imagens/350x150.jpg" id="image_preview">
                                <div class="caption">
                                    <h3>Visualização</h3>
                                    <div id="thumb_info">

                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <button id="mostrar_original" type="button" >Mostrar original</button>
                <ul class="thumbnails" id="image_original_wrap">
                    <li>
                        <img alt="Carregue uma imagem primeiro" src="" id="image_original">
                        <!--<img class="loading" alt="loading..." src="publico/imagens/loader.gif" style="display: none;">-->
                        <div>
                            <h3>Imagem original</h3>
                            <div id="master_info">

                            </div>
                        </div>

                    </li>
                </ul>
            </div>
        </div>
    </fieldset>

    <button class="btn btn-large" type="reset">Limpar tudo</button>
    <button class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit">Cadastrar</button>

</form>
<script src="publico/js/carregarImagem/jquery-ajax-image-upload.js"></script>
<script>

    function alternar_exibir_original() {

        $("#image_original_wrap").toggle(400);
//        if ($("#image_original_wrap").prop("hidden")) {
//            $("#mostrar_original").text("Ocultar");
//            $("#image_original_wrap").show();
//        }
//        else {
//            $("#mostrar_original").text("Mostrar");
//            $("#image_original_wrap").hide();
//        }
    }
    $(document).ready(function() {
        $("#image_original_wrap").toggle();
        $("#image-info").hide();
        var elem = $("#chars");
        $("#descricoes").limiter(1000, elem);

        configurar_upload_imagem("#image_preview", "#image_original", "#upload-image-form", "index.php?c=imagens&a=processarimagem");
        formularioAjax();
        varrerCampos();


        $("#mostrar_original").on("click", function() {
            alternar_exibir_original();
        });

        varrerCampos();

        $(".line input").popover({trigger: 'focus', container: 'body'});
        formularioAjax("upload-image-form");

        $("button[type=reset]").bind("click", function() {
            $("select").val('').trigger("chosen:updated");
            $("div.chosen-container li.search-choice").remove();
            $("div.chosen-container li.search-field").addClass("default");
            setTimeout(function() {
                liberarCadastro();
            }, "200");
            $("[name=categoria]").trigger('change');
            $("#image_original_wrap").css("display", "none");
            $("#image-info").hide();
            $("#remove-image-upload").click();

        });

        $("[name=categoria]").on('change', function() {
            if ($(this).val() != "default") {
                var $url = "index.php?c=imagens&a=obterSubcategorias&categoriaID=" + $(this).val();
                $("#subcategorias_wrap").load($url, function(response, status, xhr) {
                    if (status == "error") {
                        var msg = "Problema ao recuperar subcategorias. Tente novamente. ";
                        $("#subcategorias_wrap").html(msg + xhr.status + " " + xhr.statusText);
                    } else if (status == "success") {
                        varrerCampos();
                    }
                });
            } else {
                $("#subcategorias_wrap").load("index.php?c=imagens&a=obterSubcategorias");
            }

        });

    });
</script>