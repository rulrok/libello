<?php

class VerificarEdicaoCurso extends verificadorFormularioAjax {

    public function _validar() {


        $area = filter_input(INPUT_POST, 'area');
        $nomeCurso = filter_input(INPUT_POST, 'nomecurso');
        $tipoCurso = filter_input(INPUT_POST, 'tipocurso');
        $cursoID = fnDecrypt(filter_input(INPUT_POST, 'cursoID'));


        $cursoNovo = new Curso();
        $cursoNovo->set_nome($nomeCurso);
        $cursoNovo->set_idArea($area);
        $cursoNovo->set_idTipo($tipoCurso);

        $cursoDAO = new cursoDAO();
        $curso = $cursoDAO->recuperarCurso($cursoID);

        if ($curso->get_nome() == "") {
            $this->mensagemErro("Nome inconsistentes");
        }

        if ($cursoDAO->atualizar($cursoID, $cursoNovo)) {
            $this->mensagemSucesso("Atualização concluída");
        } else {
            $this->mensagemErro("Atualização mal sucedida");
        }
    }

}

$verificarEdicaoCurso = new VerificarEdicaoCurso();
$verificarEdicaoCurso->verificar();
?>
