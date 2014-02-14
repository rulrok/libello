<?php

include APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/ImagemCategoria.php";
include APP_LOCATION . "visao/verificadorFormularioAjax.php";

class verificarnovacategoria extends verificadorFormularioAjax {

    public function _validar() {
        $nomeCategoria = $_POST['categoria'];
        //Vai validar os dados
        try {
            $categoria = new ImagemCategoria();
            $categoria->set_nomeCategoria($nomeCategoria);

            $nomeCategoria = abstractDAO::quote($nomeCategoria);
            
            $resultado = imagensDAO::consultarCategorias("*", "nomeCategoria LIKE $nomeCategoria");
            if (sizeof($resultado) > 0) {
                $this->mensagem->set_mensagem("Categoria já cadastrada")->set_status(Mensagem::ERRO);
            } else {
                if (imagensDAO::cadastrarCategoria($categoria)) {
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

$verificar = new verificarnovacategoria();
$verificar->verificar();
?>
