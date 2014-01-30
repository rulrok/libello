<?php

require_once APP_LOCATION . "modelo/vo/livro.php";
require_once APP_LOCATION . "visao/verificadorFormularioAjax.php";

class verificarEdicao extends verificadorFormularioAjax {

    public function _validar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;

            $livroID = fnDecrypt($_POST['livroID']);
            $livroNome = $_POST['livro'];
            $dataEntrada = $_POST['dataEntrada'];
            $quantidade = $_POST['quantidade'];
            $descricao = $_POST['descricao'];
            $numeroPatrimonio = $_POST['numeroPatrimonio'];
            $tipolivro = $_POST['tipo'];
            $grafica = $_POST['grafica'];
            $area = $_POST['area'];

            if ($livroNome != "") {
                $livro = livroDAO::recuperarlivro($livroID);

                $numPatrimonio = $livro->get_numeroPatrimonio();

//                $this->mensagem->set_mensagem(print_r($livro,true));
//                return;
                if ($tipolivro === "custeio") {
                    if (($numPatrimonio != "") && !livroDAO::livroPodeTerTipoAlterado($livroID)) {
                        $this->mensagem->set_mensagem("Não é possível alterar o tipo")->set_status(Mensagem::ERRO);
                        return;
                    }
                    //É um item de custeio
                    $numeroPatrimonio = null;
                } else {
                    if ($numPatrimonio === "NULL" && !livroDAO::livroPodeTerTipoAlterado($livroID)) {
                        $this->mensagem->set_mensagem("Não é possível alterar o tipo")->set_status(Mensagem::ERRO);
                        return;
                    }
                    //É um patrimônio
                    $quantidade = 1;
                }
                if ($quantidade > 0) {
                    $livro->set_nomelivro($livroNome)->set_dataEntrada($dataEntrada)->set_numeroPatrimonio($numeroPatrimonio)->set_quantidade($quantidade)->set_descricao($descricao)->set_grafica($grafica)->set_area($area);

                    if (livroDAO::atualizar($livroID, $livro)) {
                        livroDAO::registrarAlteracaolivro($livroID);
                        $this->mensagem->set_mensagem("Atualizado com sucesso");
                        $this->mensagem->set_status(Mensagem::SUCESSO);
                    } else {
                        $this->mensagem->set_mensagem("Um erro ocorreu ao cadastrar no banco");
                        $this->mensagem->set_status(Mensagem::ERRO);
                    }
                } else {
                    $this->mensagem->set_mensagem("Quantidade deve ser maior que 0");
                    $this->mensagem->set_status(Mensagem::ERRO);
                }
            } else {
                $this->mensagem->set_mensagem("Nome inválido");
                $this->mensagem->set_status(Mensagem::ERRO);
            }
        endif;
    }

}

$verificarEdicao = new verificarEdicao();
$verificarEdicao->verificar();
?>
