<title>Editando usuário <?php echo $this->nome; ?></title>
<!-- Início da página -->
<form class="table centered" id="ajaxForm" method="post" action="index.php?c=usuario&a=verificaredicao">
    <fieldset>
        <legend>Dados</legend>
        <p class="centered centeredText boldedText">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png"> são obrigatórios</label>
        <div class="line">
            <label>Nome</label>
            <input required name="nome" class="campoObrigatorio" type="text" value="<?php echo $this->nome ?>">
        </div>
        <div class="line">
            <label>Sobrenome</label>
            <input required name="sobrenome" class="campoObrigatorio" type="text" value="<?php echo $this->sobrenome ?>">
        </div>
        <div class="line">
            <label>email</label>
            <input readonly type="text" name="email" value="<?php echo $this->email ?>">
        </div>
        <div class="line">
            <label>Data de nascimento</label>
            <input type="text" readonly id="dataNascimento" class="campoData" name="dataNascimento" value="<?php echo $this->dataNascimento ?>" >
        </div>
        <div class="line">
            <label>Papel no sistema</label>
            <?php echo $this->comboPapel ?>
<!--            <input id="papel" type="text" name="papel" value="">-->
        </div>
        <br/>
        <fieldset>
            <legend>Permissões por ferramenta</legend>
            <?php echo $this->comboPermissoes ?>
        </fieldset>

    </fieldset>
    <input disabled class=" btn btn-primary btn-right" type="submit" disabled value="Atualizar dados">

</form>




<script>
    $(document).ready(function() {
        varrerCampos();
        formularioAjax();
        
        $("#dataNascimento").datepick();


        $('[name=papel]').val("<?php echo $this->idPapel ?>");

        var obj = <?php echo json_encode($this->permissoes) ?>;
        var nome, idFerramenta, idPermissao, element;
        for (var i = 0; i < obj.length; i++) {
            element = obj[i];
            nome = element['nome'].toLowerCase();
//        idFerramenta = element['idFerramenta'];
            idPermissao = element['idPermissao'];

            $('[name$="' + nome + '"]').val(idPermissao);
        }
    });

</script>
