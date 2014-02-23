<?php

include_once APP_LOCATION . "modelo/Mensagem.php";
include_once APP_LOCATION . "visao/verificadorFormularioAjax.php";

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
            $this->mensagemErro("Data de retorno inválida");
        }
        $recuperarSaidalivro = $livroDAO->recuperarSaidalivro($saidaID);
        if ($recuperarSaidalivro['quantidadeSaida'] != $quantidadeMaxima) {
            $this->mensagemErro("Dados inconsistentes");
        }
        if ($quantidade <= 0 || $quantidade > $quantidadeMaxima) {
            $this->mensagemErro("Quantidade informada inválida");
        }

        if ($livroDAO->cadastrarRetorno($saidaID, $dataRetorno, $quantidade, $observacoes)) {
            $id = $livroDAO->obterUltimoIdInserido();
            $livroDAO->registrarRetorno($id);
            if ($quantidade > 1) {
                $this->mensagemSucesso("livros retornados");
            } else {
                $this->mensagemSucesso("livro retornado");
            }
        } else {
            $this->mensagemErro("Erro ao cadastrar no banco")->set_status(Mensagem::ERRO);
        }
    }

}

$registrarSaida = new registrarSaida();
$registrarSaida->verificar();
?>