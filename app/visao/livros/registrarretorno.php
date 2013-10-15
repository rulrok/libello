<?php

include_once APP_LOCATION . "modelo/Mensagem.php";
include_once APP_LOCATION . "visao/verificadorFormularioAjax.php";

class registrarSaida extends verificadorFormularioAjax {

    public function _validar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;
            $saidaID = fnDecrypt($_POST['saidaID']);
            $livroID = fnDecrypt($_POST['livroID']);
            $dataRetorno = $_POST['dataRetorno'];
            $observacoes = $_POST['observacoes'];
            $quantidade = (int) $_POST['quantidade'];
            $quantidadeMaxima = (int) $_POST['quantidadeMaxima'];



            if ($livroID >= 0 && $dataRetorno !== "" && $quantidade > 0 && $quantidade <= $quantidadeMaxima) {
                $recuperarSaidalivro = livroDAO::recuperarSaidalivro($saidaID);
                if ($recuperarSaidalivro['quantidadeSaida'] == $quantidadeMaxima) {
                    if (livroDAO::cadastrarRetorno($saidaID, $dataRetorno, $quantidade, $observacoes)) {
                        if ($quantidade > 1) {
                            $this->mensagem->set_mensagem("livros retornados");
                        } else {
                            $this->mensagem->set_mensagem("livro retornado");
                        }
                        $this->mensagem->set_status(Mensagem::SUCESSO);
                    } else {
                        $this->mensagem->set_mensagem("Erro ao cadastrar no banco")->set_status(Mensagem::ERRO);
                    }
                } else {
                    $this->mensagem->set_mensagem("Violação de dados")->set_status(Mensagem::ERRO);
                }
            } else {
                $this->mensagem->set_mensagem("Dados inválidos")->set_status(Mensagem::ERRO);
            }
        endif;
    }

}

$registrarSaida = new registrarSaida();
$registrarSaida->verificar();
?>