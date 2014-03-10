<title>Nova imagem</title>
<!-- Início da página -->
<div id="showimg"> </div>

<form class="tabela centralizado" id="upload-image-form-ajax" method="POST" action="index.php?c=imagens&a=verificarnovaimagem" enctype='multipart/form-data'>
    <fieldset>
        <legend>Dados da imagem</legend>
        <p class="centralizado textoCentralizado textoNegrito">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png" alt="Campo obrigatório"> são obrigatórios</p>
        <div class="line">
            <label for='titulo'>Título</label>
            <input required autofocus type="text" id="titulo" name="titulo" class="input-xlarge" placeholder="Nome da imagem" data-content="Título da imagem">
        </div>
        <div class="line">
            <label for='ano'>Ano</label>
            <input required size="4" type="number" maxlength="4" id="ano" name="ano" class="input-xlarge" placeholder="Ano de criação da imagem">
        </div>
        <hr>
        <p>Campos preenchidos automaticamente:</p>
        <div class="line">
            <label>CPF (autor)</label>
            <input required disabled type="text" maxlength="11" id="cpfautor" name="cpfautor" class="disabled input-xlarge" placeholder="___.___.___-__" data-content="Seu CPF cadastrado no sistema." value="<?php echo $this->cpfAutor; ?>">
        </div>
        <div class="line">
            <label for='iniciaisAutor'>Iniciais do autor</label>
            <input required disabled type="text" maxlength="11" id="iniciaisAutor" name="iniciaisAutor" class="disabled input-medium"  value="<?php echo $this->iniciaisAutor; ?>">
        </div>
        <hr>
        <div class="line">
            <label for="observacoes">Observações</label>
            <textarea rows="8" id="descricoes" name="observacoes" class="input-xlarge" title="Observações" data-content="Alguma característica da imagem ao qual o registro seja pertinente. Limite de 1000 caracteres." ></textarea>           
            <div id="chars">1000</div>
        </div>
        <div class="line">
            <label for='descritor1'>Descritor 1</label>
            <select required id="descritor_1" class="cb_descritor input-xlarge" name="descritor1">
                <?php echo $this->comboBoxDescritor; ?>
            </select>
        </div>
        <div class="line">
            <label for='descritor2'>Descritor 2</label>
            <select required id="descritor_2" class="cb_descritor input-xlarge" name="descritor2">
                <option value="default">-- Escolha um descritor acima --</option>
            </select>
        </div>
        <div class="line">
            <label for='descritor3'>Descritor 3</label>
            <select required id="descritor_3" class="cb_descritor input-xlarge" name="descritor3">
                <option value="default">-- Escolha um descritor acima --</option>
            </select>
        </div>
        <div class="line">
            <label for='descritor4'>Descritor 4</label>
            <select required id="descritor_4" class="cb_descritor input-xlarge" name="descritor4">
                <option value="default">-- Escolha um descritor acima --</option>
            </select>
        </div>
        <br/>
        <blockquote>
            <i>Não encontrou o descritor desejado?</i>
            <a class="btn btn-link" target="_blank" href="mailto:daeb.bei-bi@inep.gov.br?subject=Cadastro de descritor&body=Olá,%0D%0A%0D%0ANecessito cadastrar uma imagem e não encontrei nenhuma sequencia de descritores que se adequem aos critérios da minha figura.%0D%0AVenho por meio deste solicitar o cadastro da seguinte sequência de descritores:%0D%0A%0D%0AGrato, <?php echo $this->nomeUsuario; ?>">Solicitar cadastro de novo descritor</a>
        </blockquote>
        <div class="line">
            <label for="complexidade">Complexidade</label>
            <div class="btn-toolbar" style="position:relative;left:15px;margin-bottom: 5px;">
                <div id="complexidade_botoes" class="btn-group" data-toggle="buttons-radio">
                    <button type="button" class="btn active" id="simples_botao">Baixa</button>
                    <button type="button" class="btn" id="media_botao">Média</button>
                    <button type="button" class="btn" id="alta_botao">Alta</button>
                    <button type="button" class="btn" id="muitoalta_botao">Muito alta</button>
                </div>
                <img src="publico/imagens/icones/campo_obrigatorio.png" style="display: initial;">
                <div class="hidden">
                    <input type="radio" name="complexidade" id="simples_radio" value="A" checked/>
                    <input type="radio" name="complexidade" id="media_radio" value="B"/>
                    <input type="radio" name="complexidade" id="alta_radio" value="C"/>
                    <input type="radio" name="complexidade" id="muitoalta_radio" value="D"/>
                </div>
            </div>

        </div>
        <br/>
    </fieldset>
    <fieldset>
        <legend>Imagem</legend>

        <div class="centralizado">
            <div class="line" style="line-height: 45px;">
                <label for="raw-image-upload">Arquivo vetorizado da imagem</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
                <input required type="file" accept=".svg,.cdr,imagem/svg+xml" name="raw-image-upload" id="raw-image-upload" class="btn btn-small btn-warning"> 
            </div>

            <div class="line" id="image-upload-line" style="line-height: 45px;">
                <label for="image-upload">Arquivo de imagem</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
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
                                <img class="img-polaroid" alt="picture" src="publico/imagens/350x150.jpg" id="image_preview">
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
                        <img class="img-polaroid" alt="Carregue uma imagem primeiro" src="" id="image_original">
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
    <button class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit">Enviar</button>

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
                        ,type: "POST"
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

    function atualizar_combobox(combo_box) {
        $(combo_box).on('change', function() {
            var desnum = parseInt(this.id.substr(10));
            if (desnum > 0 && desnum < 4) {
                var wrap_id = "#descritor_" + (desnum + 1);
//                console.log(wrap_id);
//                console.log(this.name);
                if (this.selectedIndex !== 0) {
                    var $url = "index.php?c=imagens&a=obterDescritor&n=" + desnum + "&p=" + this.value;
//                    console.log($url);
                    $(wrap_id).load($url, function(response, status, xhr) {
                        if (status == "error") {
                            $(this).val("default");
//                        var msg = "Problema ao recuperar os descritores. Tente novamente. ";
//                        $("#descritor2_wrap").html(msg + xhr.status + " " + xhr.statusText);
                        } else if (status == "success") {
//                                liberarCadastro();
                            atualizar_combobox($("#descritor_" + (desnum + 1)));
                        }
                    });
                } else {
                    $(wrap_id).load("index.php?c=imagens&a=obterDescritor");
                }
            }
        });
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

        var botoes_radio_fake = $("#complexidade_botoes").children();
        $.each(botoes_radio_fake, function() {
            $(this).on('click', function() {
                var id = this.id;
                var limite = id.search("_");
                id = id.substr(0, limite + 1) + "radio";
                $("#" + id).trigger('click');
//                liberarCadastro();
            });
        });

        var cb_descritores = $(".cb_descritor");
//        console.log(cb_descritores);
        $.each(cb_descritores, function() {
            atualizar_combobox(this);
        });
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
//            $("[name=categoria]").trigger('change');
//            $("#remove-image-upload").click();
//            $("#simples_botao").click();
//            for (var i = 4; i > 0; i--) {
//                $("#descritor" + i).val('default').trigger('change');
//            }
//            setTimeout(function() {
//                $("#cpfautor").mask('999.999.999-99');
//                liberarCadastro();
//            }, "200");
            ajax("index.php?c=imagens&a=novaImagem", ".contentWrap", true, false, true); //TODO tirar essa gambiarra =s
        });






    });
</script>