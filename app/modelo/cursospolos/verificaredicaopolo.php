<?php

class VerificarEdicaoPolo extends verificadorFormularioAjax {

    public function _validar() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;
            $poloID = fnDecrypt($_POST['poloID']);
            $nomepolo = $_POST['nomepolo'];
            $estado = $_POST['estado'];
            $cidade = $_POST['cidade'];

            $poloNovo = new Polo();
            $poloNovo->set_nome($nomepolo);
            $poloNovo->set_estado($estado);
            $poloNovo->set_cidade($cidade);

            $polo = poloDAO::recuperarPolo($poloID);

            if ($polo->get_nome() != "") {

                if (poloDAO::atualizar($poloID, $poloNovo)) {
                    $this->mensagem->set_mensagem("Atualização concluída");
                    $this->mensagem->set_status(Mensagem::SUCESSO);
                } else {
                    $this->mensagem->set_mensagem("Atualização mal sucedida");
                    $this->mensagem->set_status(Mensagem::ERRO);
                }
            } else {
                $this->mensagem->set_mensagem("Dados inconsistentes");
                $this->mensagem->set_status(Mensagem::ERRO);
            }
        endif;
    }

}

$verificarEdicaoPolo = new VerificarEdicaoPolo();
$verificarEdicaoPolo->verificar();
?>
