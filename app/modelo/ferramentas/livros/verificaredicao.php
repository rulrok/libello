<?php

require_once APP_DIR . "modelo/vo/Livro.php";
require_once APP_DIR . "modelo/verificadorFormularioAjax.php";

class verificarEdicao extends verificadorFormularioAjax {

    public function _validar() {

        $livroID = fnDecrypt(filter_input(INPUT_POST, 'livroID'));
        $livroNome = filter_input(INPUT_POST, 'livro');
        $dataEntrada = filter_input(INPUT_POST, 'dataEntrada');
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
        $descricao = filter_input(INPUT_POST, 'descricao');
        $numeroPatrimonio = filter_input(INPUT_POST, 'numeroPatrimonio');
        $tipolivro = filter_input(INPUT_POST, 'tipo');
        $grafica = filter_input(INPUT_POST, 'grafica');
        $area = filter_input(INPUT_POST, 'area', FILTER_VALIDATE_INT);

        if ($livroNome == "") {
            $this->adicionarMensagemErro("Nome inválido");
        }
        if ($grafica == "") {
            $this->adicionarMensagemErro("Nome da gráfica inválido");
        }
        if (!is_int($area)) {
            $this->adicionarMensagemErro("Área inválida");
        }
        if ($quantidade <= 0) {
            $this->adicionarMensagemErro("Quantidade informada inválida");
        }
        $livroDAO = new livroDAO();
        $livro = $livroDAO->recuperarlivro($livroID);

        $numPatrimonio = $livro->get_numeroPatrimonio();

        if ($tipolivro === "custeio") {
            if (($numPatrimonio != "") && !$livroDAO->livroPodeTerTipoAlterado($livroID)) {
                $this->adicionarMensagemErro("Não é possível alterar o tipo");
                return;
            }
            //É um item de custeio
            $numeroPatrimonio = null;
        } else {
            if ($numPatrimonio === null && !$livroDAO->livroPodeTerTipoAlterado($livroID)) {
                $this->adicionarMensagemErro("Não é possível alterar o tipo");
                return;
            }
            //É um patrimônio
            $quantidade = 1;
        }
        $livro->set_nomelivro($livroNome)->set_dataEntrada($dataEntrada)->set_numeroPatrimonio($numeroPatrimonio)->set_quantidade($quantidade)->set_descricao($descricao)->set_grafica($grafica)->set_area($area);

        if ($livroDAO->atualizar($livroID, $livro)) {
            $livroDAO->registrarAlteracaolivro($livroID);
            $this->adicionarMensagemSucesso("Atualizado com sucesso");
        } else {
            $this->adicionarMensagemErro("Um erro ocorreu ao cadastrar no banco");
        }
    }

}

//$verificarEdicao = new verificarEdicao();
//$verificarEdicao->executar();
?>
