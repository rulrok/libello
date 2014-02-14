<?php

require_once APP_LOCATION . "modelo/vo/ImagemCategoria.php";
require_once APP_LOCATION . "visao/verificadorFormularioAjax.php";

class verificarEdicaoCategoria extends verificadorFormularioAjax {

    public function _validar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;

            $categoriaID = fnDecrypt($_POST['categoriaID']);
            $nomeCategoria = $_POST['categoria'];

            if ($nomeCategoria != "") {
                $categoria = imagensDAO::recuperarCategoria($categoriaID);
                $categoria->set_nomeCategoria($nomeCategoria);


                if (imagensDAO::atualizarCategoria($categoriaID, $categoria)) {
                    imagensDAO::registrarAlteracaoCategoria($categoriaID);
                    $this->mensagem->set_mensagem("Atualizado com sucesso");
                    $this->mensagem->set_status(Mensagem::SUCESSO);
                } else {
                    $this->mensagem->set_mensagem("Um erro ocorreu ao cadastrar no banco");
                    $this->mensagem->set_status(Mensagem::ERRO);
                }
            } else {
                $this->mensagem->set_mensagem("Nome inválido");
                $this->mensagem->set_status(Mensagem::ERRO);
            }
        endif;
    }

}

$verificarEdicao = new verificarEdicaoCategoria();
$verificarEdicao->verificar();
?>
