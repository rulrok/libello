<?php
include APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/Polo.php";
include APP_LOCATION . "visao/verificadorFormularioAjax.php";

class VerificarNovoPolo extends verificadorFormularioAjax {

    public function _validar() {
        $estado = $_POST['estado'];
        $cidade = $_POST['cidade'];
        $nome = $_POST['nomepolo'];

        if (!strpos($estado, "selecione")) {
            if (!strpos($cidade, "selecione")) {
                if (strcmp($nome, "") != 0) {
                    $polo = new Polo();
                    $polo->set_nome($nome);
                    $polo->set_cidade($cidade);
                    $polo->set_estado($estado);
                    $this->mensagem->set_mensagem("Cadastrado com sucesso");
                    $this->mensagem->set_status(Mensagem::SUCESSO);
                    if (poloDAO::consultarPolo($polo) == 0) {
                        poloDAO::cadastrarPolo($polo);
                    } else {
                        $this->mensagem->set_mensagem("Polo já existe!");
                        $this->mensagem->set_status(Mensagem::INFO);
                    }
                } else {
                    $this->mensagem->set_mensagem("Erro ao cadastrar");
                    $this->mensagem->set_status(Mensagem::ERRO);
                }
            } else {
                $this->mensagem->set_mensagem("Erro ao cadastrar");
                $this->mensagem->set_status(Mensagem::ERRO);
            }
        } else {
            $this->mensagem->set_mensagem("Erro ao cadastrar");
            $this->mensagem->set_status(Mensagem::ERRO);
        }
    }

}

$verificarNovoPolo = new VerificarNovoPolo();
$verificarNovoPolo->verificar();
?>
