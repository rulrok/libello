<?php

namespace app\modelo\ferramentas\equipamentos;

include_once APP_DIR . "modelo/verificadorFormularioAjax.php";

use \app\modelo as Modelo;

class verificaredicao extends Modelo\verificadorFormularioAjax {

    public function _validar() {

        $equipamentoID = fnDecrypt(filter_input(INPUT_POST, 'equipamentoID'));
        $equipamentoNome = filter_input(INPUT_POST, 'equipamento');
        $dataEntrada = filter_input(INPUT_POST, 'dataEntrada');
        $quantidade = filter_input(INPUT_POST, 'quantidade');
        $descricao = filter_input(INPUT_POST, 'descricao');
        $numeroPatrimonio = filter_input(INPUT_POST, 'numeroPatrimonio');
        $tipoEquipamento = filter_input(INPUT_POST, 'tipo');

        $ocorreu_erro = false;
        if ($equipamentoNome == "") {
            $this->adicionarMensagemErro("Nome é um campo obrigatório");
            $ocorreu_erro = true;
        }
        $equipamentoDAO = new Modelo\equipamentoDAO();

        $equipamento = $equipamentoDAO->recuperarEquipamento($equipamentoID);
        $numPatrimonio = $equipamento->get_numeroPatrimonio();

        if ($tipoEquipamento === "custeio") {
            if (($numPatrimonio != "") && !$equipamentoDAO->equipamentoPodeTerTipoAlterado($equipamentoID)) {
                $this->adicionarMensagemErro("Não é possível alterar o tipo");
                $ocorreu_erro = true;
            }
            //É um item de custeio
            $numeroPatrimonio = null;
        } else {
            if ($numPatrimonio === null && !$equipamentoDAO->equipamentoPodeTerTipoAlterado($equipamentoID)) {
                $this->adicionarMensagemErro("Não é possível alterar o tipo");
                $ocorreu_erro = true;
            }
            //É um patrimônio
            $quantidade = 1;
        }
        if ($quantidade <= 0) {
            $this->adicionarMensagemErro("Quantidade inválida");
            $ocorreu_erro = true;
        }

        if ($ocorreu_erro) {
            $this->abortarExecucao();
        }

        $equipamento->set_nomeEquipamento($equipamentoNome)->set_dataEntrada($dataEntrada)->set_numeroPatrimonio($numeroPatrimonio)->set_quantidade($quantidade)->set_descricao($descricao);

        if ($equipamentoDAO->atualizar($equipamentoID, $equipamento)) {
            $equipamentoDAO->registrarAlteracaoEquipamento($equipamentoID);
            $this->adicionarMensagemSucesso("Atualizado com sucesso");
        } else {
            $this->adicionarMensagemErro("Um erro ocorreu ao cadastrar no banco");
            $this->abortarExecucao();
        }
    }

}

?>
