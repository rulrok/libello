<?php

namespace app\modelo\ferramentas\livros;

include_once APP_DIR . "modelo/verificadorFormularioAjax.php";

use \app\modelo as Modelo;

class registrarbaixa extends Modelo\verificadorFormularioAjax {

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


        $livroDAO = new Modelo\livroDAO();
        $ocorreu_erro = false;
        if ($dataBaixa == '') {
            //TODO verificar se é uma data mesmo, ao invés de apenas verificar se não é uma string vazia
            $this->adicionarMensagemErro('Data da baixa inválida');
            $ocorreu_erro = true;
        }
//        $recuperarBaixalivro = $livroDAO->recuperarBaixalivro($saidaID);
//        if ($recuperarBaixalivro['quantidadeBaixa'] != $quantidadeMaxima) {
//            $this->mensagemErro("Dados inconsistentes");
//        }
        if ($quantidade <= 0 || $quantidade > $quantidadeMaxima) {
            $this->adicionarMensagemErro("Quantidade informada inválida");
            $ocorreu_erro = true;
        }
        if ($saidaID !== "") {
            //É uma saída
            if ($livroDAO->cadastrarBaixa($livroID, $dataBaixa, $quantidade, $observacoes, $saidaID)) {
                $id = $livroDAO->obterUltimoIdInserido();
                $livroDAO->registrarCadastroBaixa($id);
                $this->adicionarMensagemSucesso("Baixa realizada com sucesso");
            } else {
                $this->adicionarMensagemErro("Erro ao cadastrar baixa");
                $ocorreu_erro = true;
            }
        } else {
            //É um livro no CEAD
            if ($livroDAO->cadastrarBaixa($livroID, $dataBaixa, $quantidade, $observacoes)) {
                $id = $livroDAO->obterUltimoIdInserido();
                $livroDAO->registrarCadastroBaixa($id);
                $this->adicionarMensagemSucesso("Baixa realizada com sucesso");
            } else {
                $this->adicionarMensagemErro("Erro ao cadastrar baixa");
                $ocorreu_erro = true;
            }
        }
        if ($ocorreu_erro) {
            $this->abortarExecucao();
        }
    }

}

?>