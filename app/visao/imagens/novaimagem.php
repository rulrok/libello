<title>Nova imagem</title>
<!-- Início da página -->
<div id="showimg"> </div>

<form class="table centered" id="upload-image-form-ajax" method="POST" action="index.php?c=imagens&a=verificarnovaimagem" enctype='multipart/form-data'>
    <fieldset>
        <legend>Dados da imagem</legend>
        <p class="centered centeredText boldedText">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png"> são obrigatórios</p>
        <div class="line">
            <label for='nome'>Título</label>
            <input required type="text" id="nome" name="nome" class="input-xlarge" placeholder="Nome da imagem">
        </div>
        <div class="line">
            <label for='nome'>Ano</label>
            <input required type="text" id="ano" name="ano" class="input-xlarge" placeholder="Ano de criação da imagem">
        </div>
        <div class="line">
            <label for='nome'>CPF (autor)</label>
            <input required type="text" maxlength="11" id="cpfautor" name="cpfautor" class="input-xlarge" placeholder="CPF do autor dos direitos da figura">
        </div>
        <div class="line">
            <label for="observacoes">Observações</label>
            <textarea rows="8" id="descricoes" name="observacoes" class="input-xlarge" title="Observações" data-content="Alguma característica da imagem ao qual o registro seja pertinente. Limite de 1000 caracteres." ></textarea>           
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
<!--            <select name="dificuldade" id="dificuldade">
                <option value="1">Fácil</option>
                <option value="2">Médio</option>
                <option value="3">Difícil</option>
            </select>-->
            <?php echo $this->comboBoxDificuldades; ?>
        </div>
        <br/>
    </fieldset>
    <fieldset>
        <legend>Imagem</legend>

        <div class="centered">
            <div class="line" style="line-height: 45px;">
                <label for="raw-image-upload">Arquivo vetorizado da imagem</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
                <input required type="file" name="raw-image-upload" id="raw-image-upload" class="btn btn-small btn-warning"> 
            </div>

            <div class="line" id="image-upload-line" style="line-height: 45px;">
                <label for="image-upload">Arquivo de imagem</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
                <input required type="file" name="image-upload" id="image-upload" class="btn btn-small btn-warning"> 
                <output id="list"></output>
            </div>
            <br/>
            <br/>
            <div id="image-info">
                <button id="remove-image-upload" style="display: none; margin-bottom: 10px; ">
                    <img src="publico/imagens/cross.png" /> Remover
                </button>
                <br/>
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
                <hr>
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
<!--<script src="publico/js/carregarImagem/jquery-ajax-image-upload.js"></script>-->
<script>

    function alternar_exibir_original() {

        $("#image_original_wrap").toggle(400, function() {
            if ($("#image_original_wrap").css("display") == "block") {
                $("#mostrar_original").text("Ocultar original");
            } else {
                $("#mostrar_original").text("Mostrar original");
            }
        });

    }

    function handleFileSelect(evt) {
        var files = evt.target.files; // FileList object

        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, f; i < files.length; i++) {
            f = files[i];
            // Only process image files.
            if (!f.type.match('image.*')) {
                continue;
            }

            var reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                return function(e) {
                    // Render thumbnail.
                    var file = e.target;
//                    ajax()
                };
            })(f);

            // Read in the image file as a data URL.
//            reader.readAsDataURL(f);
//            console.log(reader);
        }
    }

    $(document).ready(function() {

        // Check for the various File API support.
//        if (window.File && window.FileReader && window.FileList && window.Blob) {
//            // Great success! All the File APIs are supported.
//            $("#image-upload").on('change', handleFileSelect);
//        } else {
//            alert('O seu navegador não suporta a API de arquivos.');
//        }
        $("#image_original_wrap").toggle();
        $("#image-info").hide();
        var elem = $("#chars");
        $("#descricoes").limiter(1000, elem);

        $('#cpfautor').mask('000.000.000-00', {reverse: true});

//        configurar_upload_imagem("#image_preview", "#image_original", "#upload-image-form", "index.php?c=imagens&a=processarimagem");
        formularioAjax();
        varrerCampos();


        $("#mostrar_original").on("click", function() {
            alternar_exibir_original();
        });

        $(".line input").popover({trigger: 'focus', container: 'body'});

        $("button[type=reset]").bind("click", function() {
            $("select").val('').trigger("chosen:updated");
//            $("div.chosen-container li.search-choice").remove();
//            $("div.chosen-container li.search-field").addClass("default");
            setTimeout(function() {
                liberarCadastro();
            }, "200");
            $("[name=categoria]").trigger('change');
//            $("#image_original_wrap").css("display", "none");
//            $("#image-info").hide();
//            $("#remove-image-upload").click();

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