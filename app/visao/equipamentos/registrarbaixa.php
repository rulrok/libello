<?php

include_once APP_LOCATION . "modelo/Mensagem.php";
include_once APP_LOCATION . "visao/verificadorFormularioAjax.php";

class registrarBaixa extends verificadorFormularioAjax {

    public function _validar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;
            $saidaID = fnDecrypt($_POST['saidaID']);
            $equipamentoID = fnDecrypt($_POST['equipamentoID']);
            $dataBaixa = $_POST['dataBaixa'];
            $observacoes = $_POST['observacoes'];
            $quantidade = (int) $_POST['quantidade'];
            $quantidadeMaxima = (int) $_POST['quantidadeMaxima'];



            if ($equipamentoID >= 0 && $dataBaixa !== "" && $quantidade > 0 && $quantidade <= $quantidadeMaxima) {
                if ($saidaID !== "") {
                    //É uma saída
                    if (equipamentoDAO::cadastrarBaixa($equipamentoID, $dataBaixa, $quantidade, $observacoes, $saidaID)) {
                        $this->mensagem->set_mensagem("Baixa realizada com sucesso")->set_status(Mensagem::SUCESSO);
                    } else {
                        $this->mensagem->set_mensagem("Erro ao cadastrar baixa")->set_status(Mensagem::ERRO);
                    }
                } else {
                    //É um equipamento no CEAD
                    if (equipamentoDAO::cadastrarBaixa($equipamentoID, $dataBaixa, $quantidade, $observacoes)) {
                        $this->mensagem->set_mensagem("Baixa realizada com sucesso")->set_status(Mensagem::SUCESSO);
                    } else {
                        $this->mensagem->set_mensagem("Erro ao cadastrar baixa")->set_status(Mensagem::ERRO);
                    }
                }
            } else {
                $this->mensagem->set_mensagem("Dados inválidos")->set_status(Mensagem::ERRO);
            }
        endif;
    }

}

$registrarBaixa = new registrarBaixa();
$registrarBaixa->verificar();
?>