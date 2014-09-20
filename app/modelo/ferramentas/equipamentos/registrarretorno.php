<?php

include_once APP_DIR . "modelo/Mensagem.php";
include_once APP_DIR . "modelo/verificadorFormularioAjax.php";

class registrarSaida extends verificadorFormularioAjax {

    public function _validar() {
        $saidaID = fnDecrypt(filter_input(INPUT_POST, 'saidaID'));
        //TODO verificar pq esse campo
        $equipamentoID = fnDecrypt(filter_input(INPUT_POST, 'equipamentoID'));
        $dataRetorno = filter_input(INPUT_POST, 'dataRetorno');
        $observacoes = filter_input(INPUT_POST, 'observacoes');
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
        $quantidadeMaxima = filter_input(INPUT_POST, 'quantidadeMaxima', FILTER_VALIDATE_INT);


        if ($dataRetorno == '') {
            $this->adicionarMensagemErro("Data é um campo obrigatório");
        }

        if ($quantidade <= 0 || $quantidade > $quantidadeMaxima) {
            $this->adicionarMensagemErro("Quantidade inválida");
        }


        $equipamentoDAO = new equipamentoDAO();
        $recuperarSaidaEquipamento = $equipamentoDAO->recuperarSaidaEquipamento($saidaID);
        if ($recuperarSaidaEquipamento['quantidadeSaida'] != $quantidadeMaxima) {
            $this->adicionarMensagemErro("Dados inconsistentes");
        }

        if ($equipamentoDAO->cadastrarRetorno($saidaID, $dataRetorno, $quantidade, $observacoes)) {
            if ($quantidade > 1) {
                $this->adicionarMensagemSucesso("Equipamentos retornados");
            } else {
                $this->adicionarMensagemSucesso("Equipamento retornado");
            }
            $id = $equipamentoDAO->obterUltimoIdInserido();
            $equipamentoDAO->registrarRetorno($id);
        } else {
            $this->adicionarMensagemErro("Erro ao cadastrar no banco");
        }
    }

}

//$registrarSaida = new registrarSaida();
//$registrarSaida->executar();
?>