<?php

require_once APP_LOCATION . "modelo/vo/Livro.php";
require_once APP_LOCATION . "visao/verificadorFormularioAjax.php";

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
            $this->mensagemErro("Nome inválido");
        }
        if ($grafica == "") {
            $this->mensagemErro("Nome da gráfica inválido");
        }
        if (!is_int($area)) {
            $this->mensagemErro("Área inválida");
        }
        if ($quantidade <= 0) {
            $this->mensagemErro("Quantidade informada inválida");
        }
        $livroDAO = new livroDAO();
        $livro = $livroDAO->recuperarlivro($livroID);

        $numPatrimonio = $livro->get_numeroPatrimonio();

        if ($tipolivro === "custeio") {
            if (($numPatrimonio != "") && !$livroDAO->livroPodeTerTipoAlterado($livroID)) {
                $this->mensagemErro("Não é possível alterar o tipo");
                return;
            }
            //É um item de custeio
            $numeroPatrimonio = null;
        } else {
            if ($numPatrimonio === "NULL" && !$livroDAO->livroPodeTerTipoAlterado($livroID)) {
                $this->mensagemErro("Não é possível alterar o tipo");
                return;
            }
            //É um patrimônio
            $quantidade = 1;
        }
        $livro->set_nomelivro($livroNome)->set_dataEntrada($dataEntrada)->set_numeroPatrimonio($numeroPatrimonio)->set_quantidade($quantidade)->set_descricao($descricao)->set_grafica($grafica)->set_area($area);

        if ($livroDAO->atualizar($livroID, $livro)) {
            $livroDAO->registrarAlteracaolivro($livroID);
            $this->mensagemSucesso("Atualizado com sucesso");
        } else {
            $this->mensagemErro("Um erro ocorreu ao cadastrar no banco");
        }
    }

}

$verificarEdicao = new verificarEdicao();
$verificarEdicao->verificar();
?>
