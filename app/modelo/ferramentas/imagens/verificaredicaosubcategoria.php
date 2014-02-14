<?php

require_once APP_LOCATION . "modelo/vo/ImagemSubcategoria.php";
require_once APP_LOCATION . "visao/verificadorFormularioAjax.php";

class verificarEdicaoCategoria extends verificadorFormularioAjax {

    public function _validar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;

            $subcategoriaID = fnDecrypt($_POST['subcategoriaID']);
            $nomeSubcategoria = $_POST['subcategoria'];
            $categoriapaiID = fnDecrypt($_POST['categoriapai']);

            if ($nomeSubcategoria != "" && $categoriapaiID != "") {
                $subcategoria = imagensDAO::recuperarSubcategoria($subcategoriaID);
                $subcategoria->set_nomeSubcategoria($nomeSubcategoria)->set_categoriaPai($categoriapaiID);


                if (imagensDAO::atualizarSubcategoria($subcategoriaID, $subcategoria)) {
                    imagensDAO::registrarAlteracaoSubcategoria($subcategoriaID);
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
