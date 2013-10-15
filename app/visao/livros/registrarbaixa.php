<?php

include_once APP_LOCATION . "modelo/Mensagem.php";
include_once APP_LOCATION . "visao/verificadorFormularioAjax.php";

class registrarBaixa extends verificadorFormularioAjax {

    public function _validar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;
            $saidaID = $_POST['saidaID'];
            if ($saidaID !== "") {
                $saidaID = fnDecrypt($_POST['saidaID']);
            }
            $livroID = $_POST['livroID'];
            if ($livroID !== "") {
                $livroID = fnDecrypt($_POST['livroID']);
            }
            $dataBaixa = $_POST['dataBaixa'];
            $observacoes = $_POST['observacoes'];
            $quantidade = (int) $_POST['quantidade'];
            $quantidadeMaxima = (int) $_POST['quantidadeMaxima'];



            if ($livroID >= 0 && $dataBaixa !== "" && $quantidade > 0 && $quantidade <= $quantidadeMaxima) {
                if ($saidaID !== "") {
                    //É uma saída
                    if (livroDAO::cadastrarBaixa($livroID, $dataBaixa, $quantidade, $observacoes, $saidaID)) {
                        $this->mensagem->set_mensagem("Baixa realizada com sucesso")->set_status(Mensagem::SUCESSO);
                    } else {
                        $this->mensagem->set_mensagem("Erro ao cadastrar baixa")->set_status(Mensagem::ERRO);
                    }
                } else {
                    //É um livro no CEAD
                    if (livroDAO::cadastrarBaixa($livroID, $dataBaixa, $quantidade, $observacoes)) {
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