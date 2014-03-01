<title>Inserir novo usuário</title>
<!-- Início da página -->
<script src="publico/js/jquery/jquery.form.js"></script>
<script src="publico/js/ajaxForms.js"></script> 
<form class="tabela centralizado" id="ajaxForm" method="post" action="index.php?c=usuarios&a=verificarnovo">
    <fieldset>
        <legend>Informações sobre o usuário</legend>
        <p class="centralizado textoCentralizado textoNegrito">Campos com <img src="publico/imagens/icones/campo_obrigatorio.png" alt="Campo obrigatório"> são obrigatórios
        <div class="line">
            <label>Nome</label>
            <input required autofocus type="text" id="nome" class="input-xlarge" placeholder="Primeiro nome apenas" name="nome"   data-content="Apenas letras.">
        </div>
        <div class="line">
            <label>Sobrenome</label>
            <input required type="text" id="sobrenome" class="input-xlarge" placeholder="Demais nomes" name="sobrenome"  data-content="Apenas letras e espaços.">
        </div>
        <div class="line">
            <label>E-mail</label>
            <input required type="email" id="email" class="input-large" placeholder="email@dominio.com" name="email" data-content="O email será usado como login.">
        </div>
        <div class="line">
            <label for="cpf">CPF</label>
            <input required type="text" id="cpf" class="input-large" placeholder="___.___.___-__" name="cpf" data-content="Um CPF válido do usuário.">
        </div>
        <div class="line">
            <label>Data de nascimento</label>
            <input type="text" readonly id="dataNascimento" class=" input-large campoData" placeholder="Clique para escolher" name="dataNascimento" >
        </div>
        <div class="line">
            <label>Senha</label>
            <input required type="password"  name="senha" class="input-large" data-content="Quaisquer caracteres exceto 'espaço'.Mínimo de seis caracteres.">
        </div>

        <div class="line">
            <label>Confirmar Senha</label>
            <input required type="password" class="input-large" name="confsenha" >
        </div>
        <br/>
        <fieldset>
            <div class="line">
                <label for="sugestaoInteligente">Sugestão inteligente</label>
                <input id="sugestaoInteligente" type="checkbox"  checked value="" style="margin: 10px 10px 0;">
                <a id="ajuda" href="javascript:void(0);" data-toggle="Dica" title="Ao escolher um papel, as permissões são definidas automaticamente de acordo com o papel selecionado." ><i class="icon-question-sign"></i></a>
            </div>
            <div class="line">
                <label for="papel">Papel</label>
                <select required class="input-large" id="papel">
                    <?php echo $this->comboPapeis ?>
                </select>
            </div>
        </fieldset>
        <br/>
        <fieldset>
            <legend>Permissões por ferramenta</legend>
            <?php echo $this->comboPermissoes ?>
        </fieldset>
    </fieldset>
    <button class="btn btn-large" type="reset">Limpar</button>
    <button class="btn btn-large btn-success btn-primary btn-right" disabled id="submit" type="submit">Cadastrar</button>

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
        $("#dataNascimento").datepick();
        $(".line input").popover({trigger: 'focus', container: 'body'});
        $("[name=papel]").on('change', preconfigurarPermissoes);
        $('#cpf').mask('999.999.999-99');
        varrerCampos();
        formularioAjax();
        $("#ajuda").tooltip({placement: 'right'});
    });
</script>