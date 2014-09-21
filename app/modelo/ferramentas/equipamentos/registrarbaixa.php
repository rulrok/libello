<?php

namespace app\modelo\ferramentas\equipamentos;

include_once APP_DIR . "modelo/verificadorFormularioAjax.php";

use \app\modelo as Modelo;

class registrarbaixa extends Modelo\verificadorFormularioAjax {

    public function _validar() {
        $saidaID = filter_input(INPUT_POST, 'saidaID');
        if ($saidaID !== "") {
            $saidaID = fnDecrypt(filter_input(INPUT_POST, 'saidaID'));
        }
        $equipamentoID = filter_input(INPUT_POST, 'equipamentoID');
        if ($equipamentoID !== "") {
            //TODO - WHAT THE FUCK IS THIS?
            $equipamentoID = fnDecrypt(filter_input(INPUT_POST, 'equipamentoID'));
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