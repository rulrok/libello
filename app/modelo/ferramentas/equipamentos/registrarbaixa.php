<?php

include_once APP_DIR . "modelo/Mensagem.php";
include_once APP_DIR . "modelo/verificadorFormularioAjax.php";

class registrarBaixa extends verificadorFormularioAjax {

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


        if ($dataBaixa == '') {
            $this->adicionarMensagemErro("Data de baixa inválida");
        }

        if ($quantidade <= 0 || $quantidade > $quantidadeMaxima) {
            $this->adicionarMensagemErro("Quantidade inválida");
        }


        $equipamentoDAO = new equipamentoDAO();
        if ($saidaID !== "") {
            //É uma saída
            if ($equipamentoDAO->cadastrarBaixa($equipamentoID, $dataBaixa, $quantidade, $observacoes, $saidaID)) {
                $idBaixa = $equipamentoDAO->obterUltimoIdInserido();
                $equipamentoDAO->registrarCadastroBaixa($idBaixa);
                $this->adicionarMensagemSucesso("Baixa realizada com sucesso");
            } else {
                $this->adicionarMensagemErro("Erro ao cadastrar baixa");
            }
        } else {
            //É um equipamento no CEAD
            if ($equipamentoDAO->cadastrarBaixa($equipamentoID, $dataBaixa, $quantidade, $observacoes)) {
                $idBaixa = $equipamentoDAO->obterUltimoIdInserido();
                $equipamentoDAO->registrarCadastroBaixa($idBaixa);
                $this->adicionarMensagemSucesso("Baixa realizada com sucesso");
            } else {
                $this->adicionarMensagemErro("Erro ao cadastrar baixa");
            }
        }
    }

}

//$registrarBaixa = new registrarBaixa();
//$registrarBaixa->executar();
?>