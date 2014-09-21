<?php

namespace app\modelo\ferramentas\livros;

include_once APP_DIR . "modelo/verificadorFormularioAjax.php";

use \app\modelo as Modelo;

class verificaredicao extends Modelo\verificadorFormularioAjax {

    public function _validar() {

        $livroID = fnDecrypt(filter_input(INPUT_POST, 'livroID'));
        $livroNome = filter_input(INPUT_POST, 'livro');
        $dataEntrada = filter_input(INPUT_POST, 'dataEntrada');
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
        $descricao = filter_input(INPUT_POST, 'descricao');
        $numeroPatrimonio = filter_input(INPUT_POST, 'numeroPatrimonio');
        $tipolivro = filter_input(INPUT_POST, 'tipo');
        $grafica = filter_input(INPUT_POST, 'grafica');
        $area = filter_input(INPUT_POST, 'area', FILTER_VALIDATE_INT);

        $ocorreu_erro = false;
        if ($livroNome == "") {
            $this->adicionarMensagemErro("Nome inválido");
            $ocorreu_erro = true;
        }
        if ($grafica == "") {
            $this->adicionarMensagemErro("Nome da gráfica inválido");
            $ocorreu_erro = true;
        }
        if (!is_int($area)) {
            $this->adicionarMensagemErro("Área inválida");
            $ocorreu_erro = true;
        }
        if ($quantidade <= 0) {
            $this->adicionarMensagemErro("Quantidade informada inválida");
            $ocorreu_erro = true;
        }
        $livroDAO = new Modelo\livroDAO();
        $livro = $livroDAO->recuperarlivro($livroID);

        $numPatrimonio = $livro->get_numeroPatrimonio();

        if ($tipolivro === "custeio") {
            if (($numPatrimonio != "") && !$livroDAO->livroPodeTerTipoAlterado($livroID)) {
                $this->adicionarMensagemErro("Não é possível alterar o tipo");
                $ocorreu_erro = true;
//                return;
            }
            //É um item de custeio
            $numeroPatrimonio = null;
        } else {
            if ($numPatrimonio === null && !$livroDAO->livroPodeTerTipoAlterado($livroID)) {
                $this->adicionarMensagemErro("Não é possível alterar o tipo");
                $ocorreu_erro = true;
//                return;
            }
            //É um patrimônio
            $quantidade = 1;
        }
        if ($ocorreu_erro) {
            $this->abortarExecucao();
        }
        $livro->set_nomelivro($livroNome)->set_dataEntrada($dataEntrada)->set_numeroPatrimonio($numeroPatrimonio)->set_quantidade($quantidade)->set_descricao($descricao)->set_grafica($grafica)->set_area($area);

        if ($livroDAO->atualizar($livroID, $livro)) {
            $livroDAO->registrarAlteracaolivro($livroID);
            $this->adicionarMensagemSucesso("Atualizado com sucesso");
        } else {
            $this->adicionarMensagemErro("Um erro ocorreu ao cadastrar no banco");
        }
    }

}

//$verificarEdicao = new verificarEdicao();
//$verificarEdicao->executar();
?>
