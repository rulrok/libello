<?php

include APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/ImagemCategoria.php";
include APP_LOCATION . "visao/verificadorFormularioAjax.php";

class verificarnovasubcategoria extends verificadorFormularioAjax {

    public function _validar() {
        $categoriaPai = $_POST['categoriapai'];
        $nomeSubcategoria = $_POST['subcategoria'];
        //Vai validar os dados
        try {
            $subcategoria = new ImagemSubcategoria();
            $subcategoria->set_nomeSubcategoria($nomeSubcategoria)->set_categoriaPai(fnDecrypt($categoriaPai));

            $nomeSubcategoria = abstractDAO::quote($nomeSubcategoria);

            $resultado = imagensDAO::consultarSubcategorias("*", "nomeSubcategoria LIKE $nomeSubcategoria AND categoriaPai = $subcategoria->categoriaPai");
            if (sizeof($resultado) > 0) {
                $this->mensagem->set_mensagem("Subcategoria já cadastrada")->set_status(Mensagem::ERRO);
            } else {
                if (imagensDAO::cadastrarSubcategoria($subcategoria)) {
                    $this->mensagem->set_mensagem("Cadastrado com sucesso")->set_status(Mensagem::SUCESSO);
                } else {
                    $this->mensagem->set_mensagem("Erro ao cadastrar no banco de dados")->set_status(Mensagem::ERRO);
                }
            }
        } catch (Exception $e) {
            //Mensagem de erro gerada pela classe Equipamento.
            $this->mensagem->set_mensagem($e->getMessage())->set_status(Mensagem::ERRO);
        }
    }

}

$verificar = new verificarnovasubcategoria();
$verificar->verificar();
?>
