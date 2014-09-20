<?php

include_once APP_DIR . "modelo/Mensagem.php";
include_once APP_DIR . "modelo/verificadorFormularioAjax.php";

class registrarSaida extends verificadorFormularioAjax {

    public function _validar() {
        $saidaID = fnDecrypt(filter_input(INPUT_POST, 'saidaID'));
        $livroID = fnDecrypt(filter_input(INPUT_POST, 'livroID'));
        $dataRetorno = filter_input(INPUT_POST, 'dataRetorno');
        $observacoes = filter_input(INPUT_POST, 'observacoes');
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
        $quantidadeMaxima = filter_input(INPUT_POST, 'quantidadeMaxima', FILTER_VALIDATE_INT);


        $livroDAO = new livroDAO();
        if ($dataRetorno == '') {
            //TODO Verificar se a data de retorno não é inferior a data de saída
            $this->adicionarMensagemErro("Data de retorno inválida");
        }
        $recuperarSaidalivro = $livroDAO->recuperarSaidalivro($saidaID);
        if ($recuperarSaidalivro['quantidadeSaida'] != $quantidadeMaxima) {
            $this->adicionarMensagemErro("Dados inconsistentes");
        }
        if ($quantidade <= 0 || $quantidade > $quantidadeMaxima) {
            $this->adicionarMensagemErro("Quantidade informada inválida");
        }

        if ($livroDAO->cadastrarRetorno($saidaID, $dataRetorno, $quantidade, $observacoes)) {
            $id = $livroDAO->obterUltimoIdInserido();
            $livroDAO->registrarRetorno($id);
            if ($quantidade > 1) {
                $this->adicionarMensagemSucesso("Livros Retornados");
            } else {
                $this->adicionarMensagemSucesso("Livro Retornado");
            }
        } else {
            $this->adicionarMensagemErro("Erro ao cadastrar no banco")->set_status(Mensagem::ERRO);
        }
    }

}

//$registrarSaida = new registrarSaida();
//$registrarSaida->executar();
?>