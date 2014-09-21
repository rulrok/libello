<?php

namespace app\modelo\ferramentas\cursospolos;

use \app\modelo as Modelo;

class verificaredicaocurso extends Modelo\verificadorFormularioAjax {

    public function _validar() {


        $area = filter_input(INPUT_POST, 'area');
        $nomeCurso = filter_input(INPUT_POST, 'nomecurso');
        $tipoCurso = filter_input(INPUT_POST, 'tipocurso');
        $cursoID = fnDecrypt(filter_input(INPUT_POST, 'cursoID'));


        $cursoNovo = new Modelo\Curso();
        $cursoNovo->set_nome($nomeCurso);
        $cursoNovo->set_idArea($area);
        $cursoNovo->set_idTipo($tipoCurso);

        $cursoDAO = new Modelo\cursoDAO();
        $curso = $cursoDAO->recuperarCurso($cursoID);

        if ($curso->get_nome() == "") {
            $this->adicionarMensagemErro("Nome inconsistentes");
        }

        if ($cursoDAO->atualizar($cursoID, $cursoNovo)) {
            $this->adicionarMensagemSucesso("Atualização concluída");
        } else {
            $this->adicionarMensagemErro("Atualização mal sucedida");
        }
    }

}

//$verificarEdicaoCurso = new VerificarEdicaoCurso();
//$verificarEdicaoCurso->executar();
?>
