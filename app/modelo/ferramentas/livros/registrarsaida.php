<?php

namespace app\modelo\ferramentas\livros;

include_once APP_DIR . "modelo/verificadorFormularioAjax.php";

use \app\modelo as Modelo;

class registrarsaida extends Modelo\verificadorFormularioAjax {

    public function _validar() {
        $livroID = fnDecrypt(filter_input(INPUT_POST, 'livroID'));
        $dataSaida = filter_input(INPUT_POST, 'dataSaida');
        $ocorreu_erro = false;

        if (!filter_has_var(INPUT_POST, 'destinoManual')) {
            $polo = filter_input(INPUT_POST, 'polo');
            if ($polo == 'default') {
                $this->adicionarMensagemErro("Destino inválido");
                $ocorreu_erro = true;
            } else {
                $destino = fnDecrypt($polo);
                $destinoAlternativo = null;
            }
        } else {
            $destino = null;
            $destinoAlternativo = filter_input(INPUT_POST, 'destinoManualF');
        }
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
        $responsavel = fnDecrypt(filter_input(INPUT_POST, 'responsavel'));

        if ($dataSaida == "") {
            $this->adicionarMensagemErro("Data de saída inválida");
            $ocorreu_erro = true;
        }
        if (($destino == null || $destino == "" || $destinoAlternativo !== null) && ($destino !== null || $destinoAlternativo === "")) {
            $this->adicionarMensagemErro("Destino inválido");
            $ocorreu_erro = true;
        }
        if ($quantidade <= 0) {
            $this->adicionarMensagemErro("Quantidade informada inválida");
            $ocorreu_erro = true;
        }

        if ($ocorreu_erro) {
            $this->abortarExecucao();
        }

        $livroDAO = new Modelo\livroDAO();
        if ($livroDAO->cadastrarSaida($livroID, $responsavel, $destino, $destinoAlternativo, $quantidade, $dataSaida)) {
            $id = $livroDAO->obterUltimoIdInserido();
//            $livroDAO->registrarCadastroSaida($id);
            $this->adicionarMensagemSucesso("Saída registrada");
        } else {
            $this->adicionarMensagemErro("Erro ao cadastrar no banco");
        }
    }

}

?>