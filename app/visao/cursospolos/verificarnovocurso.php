<?php

include APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/Curso.php";
include APP_LOCATION . "visao/verificadorFormularioAjax.php";

class VerificarNovoCurso extends verificadorFormularioAjax {

    public function _validar() {
        $curso = $_POST['nomecurso'];
        $area = $_POST['area'];
        $tipocurso = $_POST['tipocurso'];

        if (!strpos($tipocurso, "selecione")) {
            if (!strpos($area, "selecione")) {
                if (strcmp($curso, "") != 0) {
                    $novocurso = new Curso();
                    $novocurso->set_nome($curso);
                    $novocurso->set_area($area);
                    $novocurso->set_tipo($tipocurso);
                    if (cursoDAO::consultarCurso($novocurso) == 0) {
                        cursoDAO::cadastrarCurso($novocurso);
                        $this->mensagem->set_mensagem("Cadastrado com sucesso.");
                        $this->mensagem->set_status(Mensagem::SUCESSO);
                    } else {
                        $this->mensagem->set_mensagem("Curso já existe!");
                        $this->mensagem->set_status(Mensagem::INFO);
                    }
                } else {
                    $this->mensagem->set_mensagem("Erro ao cadastrar");
                    $this->mensagem->set_status(Mensagem::ERRO);
                }
            } else {
                $this->mensagem->set_mensagem("Erro ao cadastrar");
                $this->mensagem->set_status(Mensagem::ERRO);
            }
        } else {
            $this->mensagem->set_mensagem("Erro ao cadastrar");
            $this->mensagem->set_status(Mensagem::ERRO);
        }
    }

}

$verificarNovoCurso = new VerificarNovoCurso();
$verificarNovoCurso->verificar();
?>
