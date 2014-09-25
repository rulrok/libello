<?php

namespace app\modelo\ferramentas\equipamentos;

include_once APP_DIR . "modelo/verificadorFormularioAjax.php";

use \app\modelo as Modelo;

class registrarbaixa extends Modelo\verificadorFormularioAjax {

    public function _validar() {
        $saidaID = filter_input(INPUT_POST, 'saidaID');
        if ($saidaID !== "") {
            $saidaID = fnDecrypt($saidaID);
        }
        $equipamentoID = filter_input(INPUT_POST, 'equipamentoID');
        if ($equipamentoID !== "") {
            $equipamentoID = fnDecrypt($equipamentoID);
        }
        $dataBaixa = filter_input(INPUT_POST, 'dataBaixa');
        $observacoes = filter_input(INPUT_POST, 'observacoes');
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
        $quantidadeMaxima = filter_input(INPUT_POST, 'quantidadeMaxima', FILTER_VALIDATE_INT);


        $ocorreu_erro = false;
        if ($dataBaixa == '') {
            $this->adicionarMensagemErro("Data de baixa inválida");
            $ocorreu_erro = true;
        }

        if ($quantidade <= 0 || $quantidade > $quantidadeMaxima) {
            $this->adicionarMensagemErro("Quantidade inválida");
            $ocorreu_erro = true;
        }

        if ($ocorreu_erro) {
            $this->abortarExecucao();
        }


        $equipamentoDAO = new Modelo\equipamentoDAO();
        if ($saidaID !== "") {
            $saida = $equipamentoDAO->recuperarSaidaEquipamento($saidaID);
            if (is_null($saida)) {
                $this->adicionarMensagemErro("Essa saída não existe mais.");
                $this->abortarExecucao();
            }
            //É uma saída
            if ($equipamentoDAO->cadastrarBaixa($equipamentoID, $dataBaixa, $quantidade, $observacoes, $saidaID)) {
                $idBaixa = $equipamentoDAO->obterUltimoIdInserido();
//                $equipamentoDAO->registrarCadastroBaixa($idBaixa);
                $this->adicionarMensagemSucesso("Baixa realizada com sucesso");
            } else {
                $this->adicionarMensagemErro("Erro ao cadastrar baixa");
                $this->abortarExecucao();
            }
        } else {
            //É um equipamento no CEAD
            $equipamento = $equipamentoDAO->recuperarEquipamento($equipamentoID);
            if (is_null($equipamento)) {
                $this->adicionarMensagemErro("Esse equipamento não existe mais.");
                $this->abortarExecucao();
            }
            if ($equipamentoDAO->cadastrarBaixa($equipamentoID, $dataBaixa, $quantidade, $observacoes)) {
                $idBaixa = $equipamentoDAO->obterUltimoIdInserido();
//                $equipamentoDAO->registrarCadastroBaixa($idBaixa);
                $this->adicionarMensagemSucesso("Baixa realizada com sucesso");
            } else {
                $this->adicionarMensagemErro("Erro ao cadastrar baixa");
                $this->abortarExecucao();
            }
        }
    }

}

?>