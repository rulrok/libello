<?php

require_once APP_DIR . "modelo/vo/Equipamento.php";
require_once APP_DIR . "visao/verificadorFormularioAjax.php";

class verificarEdicao extends verificadorFormularioAjax {

    public function _validar() {

        $equipamentoID = fnDecrypt(filter_input(INPUT_POST, 'equipamentoID'));
        $equipamentoNome = filter_input(INPUT_POST, 'equipamento');
        $dataEntrada = filter_input(INPUT_POST, 'dataEntrada');
        $quantidade = filter_input(INPUT_POST, 'quantidade');
        $descricao = filter_input(INPUT_POST, 'descricao');
        $numeroPatrimonio = filter_input(INPUT_POST, 'numeroPatrimonio');
        $tipoEquipamento = filter_input(INPUT_POST, 'tipo');

        if ($equipamentoNome == "") {
            $this->mensagemErro("Nome é um campo obrigatório");
        }
        $equipamentoDAO = new equipamentoDAO();

        $equipamento = $equipamentoDAO->recuperarEquipamento($equipamentoID);
        $numPatrimonio = $equipamento->get_numeroPatrimonio();

        if ($tipoEquipamento === "custeio") {
            if (($numPatrimonio != "") && !$equipamentoDAO->equipamentoPodeTerTipoAlterado($equipamentoID)) {
                $this->mensagemErro("Não é possível alterar o tipo");
            }
            //É um item de custeio
            $numeroPatrimonio = null;
        } else {
            if ($numPatrimonio === null && !$equipamentoDAO->equipamentoPodeTerTipoAlterado($equipamentoID)) {
                $this->mensagemErro("Não é possível alterar o tipo");
            }
            //É um patrimônio
            $quantidade = 1;
        }
        if ($quantidade <= 0) {
            $this->mensagemErro("Quantidade inválida");
        }
        $equipamento->set_nomeEquipamento($equipamentoNome)->set_dataEntrada($dataEntrada)->set_numeroPatrimonio($numeroPatrimonio)->set_quantidade($quantidade)->set_descricao($descricao);

        if ($equipamentoDAO->atualizar($equipamentoID, $equipamento)) {
            $equipamentoDAO->registrarAlteracaoEquipamento($equipamentoID);
            $this->mensagemSucesso("Atualizado com sucesso");
        } else {
            $this->mensagemErro("Um erro ocorreu ao cadastrar no banco");
        }
    }

}

$verificarEdicao = new verificarEdicao();
$verificarEdicao->verificar();
?>
