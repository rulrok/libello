<?php

namespace app\modelo\ferramentas\equipamentos;

include_once APP_DIR . "modelo/verificadorFormularioAjax.php";

use \app\modelo as Modelo;

class registrarsaida extends Modelo\verificadorFormularioAjax {

    public function _validar() {
        $equipamentoID = fnDecrypt(filter_input(INPUT_POST, 'equipamentoID'));
        $dataSaida = filter_input(INPUT_POST, 'dataSaida');
        if (!filter_has_var(INPUT_POST, 'destinoManual')) {
            $destino = fnDecrypt(filter_input(INPUT_POST, 'polo'));
            $destinoAlternativo = null;
        } else {
            $destino = null;
            $destinoAlternativo = filter_input(INPUT_POST, 'destinoManual');
        }
        $quantidade = (int) filter_input(INPUT_POST, 'quantidade');
        $responsavel = fnDecrypt(filter_input(INPUT_POST, 'responsavel'));

        $ocorreu_erro = false;
        if ($dataSaida == "") {
            $this->adicionarMensagemErro("Data é um campo obrigatório");
            $ocorreu_erro = true;
        }
        if ($quantidade <= 0) {
            $this->adicionarMensagemErro("Quantidade inválida");
            $ocorreu_erro = true;
        }

        if (($destino == null || $destino == "" || $destinoAlternativo !== null) && ($destino !== null || $destinoAlternativo === "")) {
            $this->adicionarMensagemErro("Destino inválido");
            $ocorreu_erro = true;
        }

        if ($ocorreu_erro) {
            $this->abortarExecucao();
        }
        $equipamentoDAO = new Modelo\equipamentoDAO();
        if ($equipamentoDAO->cadastrarSaida($equipamentoID, $responsavel, $destino, $destinoAlternativo, $quantidade, $dataSaida)) {
            $id = $equipamentoDAO->obterUltimoIdInserido();
//            $equipamentoDAO->registrarCadastroSaida($id);
            $this->adicionarMensagemSucesso("Saída registrada");
        } else {
            $this->adicionarMensagemErro("Erro ao cadastrar no banco");
            $this->abortarExecucao();
        }
    }

}

?>