<?php

require_once APP_LOCATION . "modelo/vo/Polo.php";
require_once APP_LOCATION . "visao/verificadorFormularioAjax.php";

class VerificarNovoPolo extends verificadorFormularioAjax {

    public function _validar() {
        $estado = filter_input(INPUT_POST, 'estado');
        $cidade = filter_input(INPUT_POST, 'cidade');
        $nome = filter_input(INPUT_POST, 'nomepolo');

        if ($estado == "" || $estado == "default") {
            $this->mensagemErro("Estado inválido");
        }
        if ($cidade == "" || $cidade == "default") {
            $this->mensagemErro("Cidade inválida");
        }
        if ($nome == "") {
            $this->mensagemErro("Nome do Polo inválido");
        }
        $polo = new Polo();
        $polo->set_nome($nome);
        $polo->set_cidade($cidade);
        $polo->set_estado($estado);
        $poloDAO = new poloDAO();
        if ($poloDAO->consultarPolo($polo) == 0) {
            if ($poloDAO->cadastrarPolo($polo)) {
                $this->mensagemSucesso("Cadastrado com sucesso");
            } else {
                $this->mensagemErro("Erro ao cadastrar no banco");
            }
        } else {
            $this->mensagemAviso("Polo já existe!");
        }
    }

}

$verificarNovoPolo = new VerificarNovoPolo();
$verificarNovoPolo->verificar();
?>
