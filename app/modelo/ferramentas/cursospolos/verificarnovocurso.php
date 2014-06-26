<?php

require_once APP_DIR . "modelo/vo/Curso.php";
require_once APP_DIR . "visao/verificadorFormularioAjax.php";

class VerificarNovoCurso extends verificadorFormularioAjax {

    public function _validar() {
        $area = filter_input(INPUT_POST, 'area', FILTER_VALIDATE_INT);
        $curso = filter_input(INPUT_POST, 'nomecurso');
        $tipocurso = filter_input(INPUT_POST, 'tipocurso', FILTER_VALIDATE_INT);

        if (!is_int($tipocurso)) {
            $this->mensagemErro("Tipo de curso inválido");
        }
        if (!is_int($area)) {
            $this->mensagemErro("Área inválida");
        }
        if ($curso == "") {
            $this->mensagemErro("Nome do curso inválido");
        }

        $novocurso = new Curso();
        $novocurso->set_nome($curso);
        $novocurso->set_idArea($area);
        $novocurso->set_idTipo($tipocurso);
        $cursoDAO = new cursoDAO();
        if ($cursoDAO->consultarCurso($novocurso) == 0) {
            if ($cursoDAO->cadastrarCurso($novocurso)) {
                $this->mensagemSucesso("Cadastrado com sucesso.");
            } else {
                $this->mensagemErro("Erro ao cadastrar no banco");
            }
        } else {
            $this->mensagemAviso("Curso já existe!");
        }
    }

}

$verificarNovoCurso = new VerificarNovoCurso();
$verificarNovoCurso->verificar();
?>
