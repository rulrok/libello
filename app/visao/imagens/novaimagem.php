<title>Nova imagem</title>
<!-- Início da página -->
<div id="showimg"> </div>

<form class="table centered" id="upload-image-form-ajax" method="POST" action="index.php?c=imagens&a=verificarnovaimagem" enctype='multipart/form-data'>
    <fieldset>
        <legend>Dados da imagem</legend>
        <p class="centered centeredText boldedText">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png"> são obrigatórios</p>
        <div class="line">
            <label for='nome'>Título</label>
            <input required autofocus type="text" id="nome" name="nome" class="input-xlarge" placeholder="Nome da imagem" data-content="Título da imagem">
        </div>
        <div class="line">
            <label for='nome'>Ano</label>
            <input required type="text" id="ano" name="ano" class="input-xlarge" placeholder="Ano de criação da imagem">
        </div>
        <div class="line">
            <label for='nome'>CPF (autor)</label>
            <input required type="text" maxlength="11" id="cpfautor" name="cpfautor" class="input-xlarge" placeholder="___.___.___-__" data-content="CPF do autor dos direitos autorais da figura. Insira um CPF válido.">
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
                <select required>
                    <option>-- Escolha uma categoria --</option>
                </select>
            </span>
        </div>
        <div class="line">
            <label for="dificuldade">Dificuldade</label>
            <?php echo $this->comboBoxDificuldades; ?>
        </div>
        <br/>
    </fieldset>
    <fieldset>
        <legend>Imagem</legend>

        <div class="centered">
            <div class="line" style="line-height: 45px;">
                <label for="raw-image-upload">Arquivo vetorizado da imagem</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
                <input required type="file" accept=".svg,.cdr,imagem/svg+xml" name="raw-image-upload" id="raw-image-upload" class="btn btn-small btn-warning"> 
            </div>

            <div class="line" id="image-upload-line" style="line-height: 45px;">
                <label for="image-upload">Arquivo de imagem</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
                <input required type="file" accept="image/jpeg,image/png,image/jpg" name="image-upload" id="image-upload" class="btn btn-small btn-info"> 
                <output id="list"></output>
            </div>
            <br/>
            <img id="image-loading" alt="Carregando..." src="publico/imagens/loader.gif" style="display: none;">
            <br/>
            <div id="image-info">
                <button id="remove-image-upload" style="display: none; margin-bottom: 10px; ">
                    <img src="publico/imagens/cross.png" /> Remover
                </button>
                <br/>
                <div id="resultado_imagem">
                    <ul class="thumbnails">
                        <li class="span4">
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
//                    console.log(file.result);
//                    ajax("index.php?c=imagens&a=criarthumb&imageURI=" + file.result, "#image_preview", false, true, true);
                    $.ajax({
                        url: "index.php?c=imagens&a=criarthumb"
                        ,
                        type: "POST"
                        , async: true
                        , data: {imagemURI: file.result}
                        , success: function(data) {
                            data = $.parseJSON(data);
                            $("#image-info").show();
                            $("#image_preview").prop('src', data.thumb.img_src);
                            $("#image_original").prop('src', data.master.img_src);
                            //show img data
                            $("#thumb_info").empty();
                            $("#thumb_info").html("<p>Dimensões: " + data.thumb.w + "x" + data.thumb.h + "</p><p>Tamanho: " + data.thumb.size + "</p>");
                            $("#master_info").empty();
                            $("#master_info").html("<p>Dimensões: " + data.master.w + "x" + data.master.h + "</p><p>Tamanho: " + data.master.size + "</p>");
                            $('#remove-image-upload').show();
                            $('#image-upload-line').hide();
                        }
                        , error: function() {
                            $("#image-info").hide();
                        }
                        , beforeSend: function() {
                            $("#image-loading").show();
                        },
                        complete: function() {
                            $("#image-loading").hide();
                        }


                    });
                };

            })(f);
            reader.readAsDataURL(f);
        }
    }


    $(document).ready(function() {

        if (window.File && window.FileReader && window.FileList && window.Blob) {
            $("#image-upload").on('change', handleFileSelect);
            $('#remove-image-upload').on('click', function(e)
            {
                $('#image-upload-line').show();
                $("#image_preview").prop('src', 'publico/imagens/350x150.jpg');
                $("#image_original").prop('src', '');
                $('.img-data').remove();
                $('#remove-image-upload').hide();
                $("#thumb_info").empty();
                $("#master_info").empty();
                $("#image-info").hide();
                $("[type=file]").each(function() {
                    $(this).val("");
                });
                e.preventDefault();
                return false;
            });
        } else {
            alert('O seu navegador não suporta a API de arquivos.\nVisualizações estarão indisponíveis.');
        }
        formularioAjax();
        varrerCampos();
        //Prepara elementos
        $("#image_original_wrap").toggle();
        $("#image-info").hide();
        //Configura caixa de observações
        var elem = $("#chars");
        $("#descricoes").limiter(1000, elem);
        //Aplica mascara campo CPF
        $('#cpfautor').mask('999.999.999-99');
        $("#mostrar_original").on("click", function() {
            alternar_exibir_original();
        });
        $(".line input,.line textearea").popover({trigger: 'focus', container: 'body'});
        $("button[type=reset]").bind("click", function() {
//            $("select").val('').trigger("chosen:updated");
//            $("div.chosen-container li.search-choice").remove();
//            $("div.chosen-container li.search-field").addClass("default");
            setTimeout(function() {
                liberarCadastro();
            }, "200");
            $("[name=categoria]").trigger('change');
//            $("#image_original_wrap").css("display", "none");
//            $("#image-info").hide();
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