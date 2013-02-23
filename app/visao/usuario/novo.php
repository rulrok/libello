<form class="table centered">
    <fieldset>
                        <legend>Informações sobre o usuário</legend>
                        <span class="line">
                            <p>Nome:</p>
                            <input type="text" id="nome" name="nome" onkeyup="liberarCadastro()" style="width: 265px">
                        </span>

                        <span class="line">
                            <p>Login:</p>
                            <input type="text" id="login" name="login" onblur="checaLogin()">
                        </span>

                        <span class="line">
                            <p>Senha:</p>
                            <input type="password" id="senha" name="senha" onkeyup="liberarCadastro()" style="width: 100px">
                        </span>

                        <span class="line">
                            <p>Confirmar Senha:</p>
                            <input type="password" id="confsenha" name="confsenha" onkeyup="liberarCadastro()" style="width: 100px">
                        </span>

                        <span class="line">
                            <p>Papel:</p>
                            <select name="papel" id="papel"><option value="default" selected="selected"> -- Selecione uma opção --</option><option value="0">Administrador </option><option value="1">Gestor </option><option value="2">Professor </option><option value="3">Coordenador </option><option value="4">Estudante </option></select>                        </span>

    </fieldset>
</form>