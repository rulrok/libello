<title>Nova viagem</title>
<!-- Início da página -->
<div id="showimg"> </div>
<!--<form class="table centered" id="upload-image-form" >
    <fieldset>
        <legend>Imagem</legend>
         Inicio do carregador de imagem 
        

        <div class="cell lastcell">
            <input type="submit" value="Submit Form" class="submit-btn">
        </div>
         Final do carregador de imagem 
    </fieldset>-->
<!--</form>-->
<form class="table centered" id="upload-image-form-ajax" method="post" action="index.php?c=imagens&a=verificarnova">
    <fieldset>
        <div class="cell">
            <div class="row requiredRow">
                <label id="image-upload-ariaLabel" for="picture">Select Image:</label>
                <input type="file" size="40" name="image-upload" id="image-upload"> 
                <button id="remove-image-upload">
                    <img src="publico/imagens/cross.png" /> Remove
                </button>
            </div>
        </div>

        <div class="cell">
            <h2>Generated Image Thumbnail:</h2>
            <div id="image_preview_wrap">
                <!--<img class="loading" alt="loading..." src="publico/imagens/loading.gif">-->
                <img alt="picture" src="publico/imagens/350x150.jpg" id="image_preview">
            </div>
        </div>

        <div class="cell">
            <h2>Saved Original Image:</h2>
            <div id="image_original_wrap">
                <!--<img class="loading" alt="loading..." src="publico/imagens/loading.gif">-->
                <img alt="The original uploaded image will appear here..." src="" id="image_original">
            </div>
        </div>

    </fieldset>
    <fieldset>
        <legend>Dados da imagem</legend>
        <p class="centered centeredText boldedText">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png"> são obrigatórios</label>
        <div class="line">
            <label for='nome'>Nome da imagem</label>
            <input required type="text" id="nome" name="nome" class="input-large" placeholder="Nome da imagem">
        </div>
        <div class="line">
            <label for='curso'>Categoria</label>
            <?php // echo $this->cursos;   ?>
            <select>
                <option>Logos</option>
                <option>Ilustrações</option>
                <option>Comemorativos</option>
                <option>Oficiais</option>
            </select>
        </div>
        <div class="line" >
            <label for='polo'>Subcategoria 1</label>
            <?php // echo $this->polos;   ?>
        </div>
        <div class="line" >
            <label for='polo'>Subcategoria 2</label>
            <?php // echo $this->polos;   ?>
        </div>
    </fieldset>
    <button class="btn btn-large" type="reset">Limpar</button>
    <button class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit">Cadastrar</button>

</form>
<script src="publico/js/carregarImagem/jquery-ajax-image-upload.js"></script>
<script>
    $(document).ready(function() {



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
        });

//        var campoPolo = document.getElementById("polo");
//        optg = document.createElement("optgroup");
//        optg.title = "outro";
//        optg.label = "Outro";
//        opt = document.createElement("option");
//        opt.value = "outro";
//        opt.text = "Outro destino";
//        optg.appendChild(opt);
//        campoPolo.appendChild(optg);
//        document.viagens_campoDestinoAlternativo = false;
//
//        $("#polo").on('change', function() {
//            if ($("#polo option:selected").prop("value") === "outro") {
//                $($(".line")[1]).after("<div class='line'><label for='destinoManual'>Nome do destino</label><input type='text' required id='destinoManual' class='input-xlarge' name='destinoManual'/></div>")
//                varrerCampos();
//                document.viagens_campoDestinoAlternativo = true;
//            } else if (document.viagens_campoDestinoAlternativo) {
//                document.viagens_campoDestinoAlternativo = false;
//                $($(".line")[2]).remove();
//            }
//        });
    });
</script>