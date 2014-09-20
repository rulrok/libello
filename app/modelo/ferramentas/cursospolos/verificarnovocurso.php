<?php

require_once APP_DIR . "modelo/vo/Curso.php";
require_once APP_DIR . "modelo/verificadorFormularioAjax.php";

class VerificarNovoCurso extends verificadorFormularioAjax {

    public function _validar() {
        $area = filter_input(INPUT_POST, 'area', FILTER_VALIDATE_INT);
        $curso = filter_input(INPUT_POST, 'nomecurso');
        $tipocurso = filter_input(INPUT_POST, 'tipocurso', FILTER_VALIDATE_INT);

        if (!is_int($tipocurso)) {
            $this->adicionarMensagemErro("Tipo de curso inválido");
        }
        if (!is_int($area)) {
            $this->adicionarMensagemErro("Área inválida");
        }
        if ($curso == "") {
            $this->adicionarMensagemErro("Nome do curso inválido");
        }

        $novocurso = new Curso();
        $novocurso->set_nome($curso);
        $novocurso->set_idArea($area);
        $novocurso->set_idTipo($tipocurso);
        $cursoDAO = new cursoDAO();
        if ($cursoDAO->consultarCurso($novocurso) == 0) {
            if ($cursoDAO->cadastrarCurso($novocurso)) {
                $this->adicionarMensagemSucesso("Cadastrado com sucesso.");
            } else {
                $this->adicionarMensagemErro("Erro ao cadastrar no banco");
            }
        } else {
            $this->adicionarMensagemAviso("Curso já existe!");
        }
    }

}

//$verificarNovoCurso = new VerificarNovoCurso();
//$verificarNovoCurso->executar();
?>
