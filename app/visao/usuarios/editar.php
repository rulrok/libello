<title>Editando usuário <?php echo $this->nome; ?></title>
<!-- Início da página -->
<form class="tabela centralizado" id="ajaxForm" method="post" action="index.php?c=usuarios&a=verificaredicao">
    <fieldset>
        <legend>Dados</legend>
        <p class="centralizado textoCentralizado textoNegrito">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png" alt="Campo obrigatório"> são obrigatórios</p>
        <div class="line">
            <label for="nome">Nome</label>
            <input required autofocus id="nome" name="nome" class="campoObrigatorio" type="text" value="<?php echo $this->nome ?>">
        </div>
        <div class="line">
            <label for="sobrenome">Sobrenome</label>
            <input required id="sobrenome" name="sobrenome" class="campoObrigatorio" type="text" value="<?php echo $this->sobrenome ?>">
        </div>
        <div class="line">
            <label for="email">Email</label>
            <input readonly type="text" id="email" name="email" value="<?php echo $this->email ?>">
        </div>
        <div class="line">
            <label for="cpf">CPF</label>
            <input required type="text" id="cpf" class="input-large" placeholder="___.___.___-__" name="cpf" data-content="Um CPF válido do usuário." value="<?php echo $this->cpf; ?>">
        </div>
        <div class="line">
            <label for="dataNascimento">Data de nascimento</label>
            <input type="text" readonly id="dataNascimento" class="campoData" name="dataNascimento" value="<?php echo $this->dataNascimento ?>" >
        </div>
        <br/>
        <fieldset>
            <div class="line">
                <label for="sugestaoInteligente">Sugestão inteligente</label>
                <input id="sugestaoInteligente" type="checkbox"  value="" style="margin: 10px 10px 0;">
                <a id="ajuda" href="javascript:void(0)" data-toggle="Dica" title="Ao escolher um papel, as permissões são definidas automaticamente de acordo com o papel selecionado." ><i class="icon-question-sign"></i></a>
            </div>
            <div class="line">
                <label for="papel">Papel no sistema</label>
                <!--             <div>
                                <label for="sugestaoInteligente" style="font-size: 10px;
                                       line-height: 13px;
                                       text-align: center;">Sugestão inteligente</label>
                                <input id="sugestaoInteligente" type="checkbox" value="">
                            </div>-->
                <select required class="input-large" id="papel" name="papel">
                    <?php echo $this->comboPapel ?>
                </select>

            </div>
        </fieldset>
        <br/>
        <fieldset>
            <legend>Permissões por ferramenta</legend>
            <?php echo $this->comboPermissoes ?>
        </fieldset>

    </fieldset>
    <button class=" btn btn-left" type="button" onclick="history.back();">Voltar</button>
    <button disabled class=" btn btn-primary btn-right" type="submit">Atualizar dados</button>

</form>




<script>
    function preconfigurarPermissoes() {
        if (!$("#sugestaoInteligente").prop('checked')) {
            return false;
        }
        var valorEscolhido = $(this).context.value;
        try {
            var nome = $(this).children()[valorEscolhido].text;
        } catch (e) {
            nome = "";
        }

        var escolha;
        switch (nome) {
            case "Aluno":
                escolha = 10;
                break;
            case "Professor":
                escolha = 20;
                break;
            case "Gestor":
                escolha = 30;
                break;
            case "Administrador":
                escolha = 40;
                break;
            default:
                escolha = 0;
                break;
        }

        $("[name ^= 'permissoes']").each(function() {
            $(this).val(escolha);
        });
    }

    $(document).ready(function() {
        $('#cpf').mask('999.999.999-99');
        $("#ajuda").tooltip({placement: 'right'});
        $("#dataNascimento").datepick();

        varrerCampos();
        formularioAjax();

        $('[name=papel]').val("<?php echo $this->idPapel ?>");
        $("[name=papel]").on('change', preconfigurarPermissoes);

        var obj = <?php echo json_encode($this->permissoes) ?>;
        var nome, idPermissao, element;
        for (var i = 0; i < obj.length; i++) {
            element = obj[i];
            nome = element['nome'].toLowerCase();
//        idFerramenta = element['idFerramenta'];
            idPermissao = element['idPermissao'];

            $('[name$="' + nome + '"]').val(idPermissao);
        }
    });

</script>
