<?php

include_once APP_LOCATION . "modelo/Mensagem.php";
include_once APP_LOCATION . "visao/verificadorFormularioAjax.php";

class registrarBaixa extends verificadorFormularioAjax {

    public function _validar() {
        $saidaID = filter_input(INPUT_POST, 'saidaID');
        if ($saidaID !== "") {
            $saidaID = fnDecrypt(filter_input(INPUT_POST, 'saidaID'));
        }
        $livroID = filter_input(INPUT_POST, 'livroID');
        if ($livroID !== "") {
            $livroID = fnDecrypt(filter_input(INPUT_POST, 'livroID'));
        }
        $dataBaixa = filter_input(INPUT_POST, 'dataBaixa');
        $observacoes = filter_input(INPUT_POST, 'observacoes');
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
        $quantidadeMaxima = filter_input(INPUT_POST, 'quantidadeMaxima', FILTER_VALIDATE_INT);


        $livroDAO = new livroDAO();
        if ($dataBaixa == '') {
            //TODO verificar se é uma data mesmo, ao invés de apenas verificar se não é uma string vazia
            $this->mensagemErro('Data da baixa inválida');
        }
//        $recuperarBaixalivro = $livroDAO->recuperarBaixalivro($saidaID);
//        if ($recuperarBaixalivro['quantidadeBaixa'] != $quantidadeMaxima) {
//            $this->mensagemErro("Dados inconsistentes");
//        }
        if ($quantidade <= 0 || $quantidade > $quantidadeMaxima) {
            $this->mensagemErro("Quantidade informada inválida");
        }
        if ($saidaID !== "") {
            //É uma saída
            if ($livroDAO->cadastrarBaixa($livroID, $dataBaixa, $quantidade, $observacoes, $saidaID)) {
                $id = $livroDAO->obterUltimoIdInserido();
                $livroDAO->registrarCadastroBaixa($id);
                $this->mensagemSucesso("Baixa realizada com sucesso");
            } else {
                $this->mensagemErro("Erro ao cadastrar baixa");
            }
        } else {
            //É um livro no CEAD
            if ($livroDAO->cadastrarBaixa($livroID, $dataBaixa, $quantidade, $observacoes)) {
                $id = $livroDAO->obterUltimoIdInserido();
                $livroDAO->registrarCadastroBaixa($id);
                $this->mensagemSucesso("Baixa realizada com sucesso");
            } else {
                $this->mensagemErro("Erro ao cadastrar baixa");
            }
        }
    }

}

$registrarBaixa = new registrarBaixa();
$registrarBaixa->verificar();
?>