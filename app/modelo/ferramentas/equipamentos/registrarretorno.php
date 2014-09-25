<?php

namespace app\modelo\ferramentas\equipamentos;

include_once APP_DIR . "modelo/verificadorFormularioAjax.php";

use \app\modelo as Modelo;

class registrarretorno extends Modelo\verificadorFormularioAjax {

    public function _validar() {
        $saidaID = fnDecrypt(filter_input(INPUT_POST, 'saidaID'));
        //TODO verificar pq esse campo
        $equipamentoID = fnDecrypt(filter_input(INPUT_POST, 'equipamentoID'));
        $dataRetorno = filter_input(INPUT_POST, 'dataRetorno');
        $observacoes = filter_input(INPUT_POST, 'observacoes');
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
        $quantidadeMaxima = filter_input(INPUT_POST, 'quantidadeMaxima', FILTER_VALIDATE_INT);

        $ocorreu_erro = false;

        if ($dataRetorno == '') {
            $this->adicionarMensagemErro("Data é um campo obrigatório");
            $ocorreu_erro = true;
        }

        if ($quantidade <= 0 || $quantidade > $quantidadeMaxima) {
            $this->adicionarMensagemErro("Quantidade inválida");
            $ocorreu_erro = true;
        }


        $equipamentoDAO = new Modelo\equipamentoDAO();
        $recuperarSaidaEquipamento = $equipamentoDAO->recuperarSaidaEquipamento($saidaID);
        if ($recuperarSaidaEquipamento['quantidadeSaida'] != $quantidadeMaxima) {
            $this->adicionarMensagemErro("Dados inconsistentes");
            $ocorreu_erro = true;
        }

        if ($ocorreu_erro) {
            $this->abortarExecucao();
        }
        $saida = $equipamentoDAO->recuperarSaidaEquipamento($saidaID);
        if (is_null($saida)) {
            $this->adicionarMensagemErro("Essa saída não existe mais.");
            $this->abortarExecucao();
        }
        if ($equipamentoDAO->cadastrarRetorno($saidaID, $dataRetorno, $quantidade, $observacoes)) {
            if ($quantidade > 1) {
                $this->adicionarMensagemSucesso("Equipamentos retornados");
            } else {
                $this->adicionarMensagemSucesso("Equipamento retornado");
            }
            $id = $equipamentoDAO->obterUltimoIdInserido();
//            $equipamentoDAO->registrarRetorno($id);
        } else {
            $this->adicionarMensagemErro("Erro ao cadastrar no banco");
            $this->abortarExecucao();
        }
    }

}

?>