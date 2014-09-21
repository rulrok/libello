<?php

namespace app\modelo\ferramentas\cursospolos;

require_once APP_DIR . "modelo/vo/Polo.php";
require_once APP_DIR . "modelo/verificadorFormularioAjax.php";

use \app\modelo as Modelo;

class verificarnovopolo extends Modelo\verificadorFormularioAjax {

    public function _validar() {
        $estado = filter_input(INPUT_POST, 'estado');
        $cidade = filter_input(INPUT_POST, 'cidade');
        $nome = filter_input(INPUT_POST, 'nomepolo');

        if ($estado == "" || $estado == "default") {
            $this->adicionarMensagemErro("Estado inválido");
        }
        if ($cidade == "" || $cidade == "default") {
            $this->adicionarMensagemErro("Cidade inválida");
        }
        if ($nome == "") {
            $this->adicionarMensagemErro("Nome do Polo inválido");
        }
        $polo = new Modelo\Polo();
        $polo->set_nome($nome);
        $polo->set_cidade($cidade);
        $polo->set_estado($estado);
        $poloDAO = new Modelo\poloDAO();
        if ($poloDAO->consultarPolo($polo) == 0) {
            if ($poloDAO->cadastrarPolo($polo)) {
                $this->adicionarMensagemSucesso("Cadastrado com sucesso");
            } else {
                $this->adicionarMensagemErro("Erro ao cadastrar no banco");
            }
        } else {
            $this->adicionarMensagemAviso("Polo já existe!");
        }
    }

}

//$verificarNovoPolo = new VerificarNovoPolo();
//$verificarNovoPolo->executar();
?>
