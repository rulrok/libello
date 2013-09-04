<?php

include APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/Curso.php";
include APP_LOCATION . "visao/verificadorFormularioAjax.php";

class VerificarEdicaoCurso extends verificadorFormularioAjax {

    public function _validar() {

        $cursoID = $_POST['cursoID'];
        $nomeCurso = $_POST['nomecurso'];
        $area = $_POST['area'];
        $tipoCurso = $_POST['tipocurso'];


        $cursoNovo = new Curso();
        $cursoNovo->set_nome($nomeCurso);
        $cursoNovo->set_area($area);
        $cursoNovo->set_tipo($tipoCurso);

        $curso = cursoDAO::recuperarCurso($cursoID);

        if ($curso->get_nome() != "") {

            if (cursoDAO::atualizar($cursoID, $cursoNovo)) {
                $this->mensagem->set_mensagem("Atualização concluída");
                $this->mensagem->set_status(Mensagem::SUCESSO);
            } else {
                $this->mensagem->set_mensagem("Atualização mal sucedida");
                $this->mensagem->set_status(Mensagem::ERRO);
            }
        } else {
            $this->mensagem->set_mensagem("Dados inconsistentes");
            $this->mensagem->set_status(Mensagem::ERRO);
        }
    }

}

$verificarEdicaoCurso = new VerificarEdicaoCurso();
$verificarEdicaoCurso->verificar();
?>
