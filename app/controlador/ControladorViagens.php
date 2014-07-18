<?php

include_once APP_LIBRARY_DIR . 'Mvc/Controlador.php';
include_once APP_LIBRARY_DIR . 'seguranca/criptografia.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxCurso.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPolo.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxUsuarios.php';

class ControladorViagens extends Controlador {

    public function acaoNova() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->visao->cursos = ComboBoxCurso::montarTodosOsCursos();
        $this->visao->polos = ComboBoxPolo::montarTodosOsPolos();
        $this->visao->usuarios = ComboBoxUsuarios::listarTodosUsuarios();
        $this->renderizar();
    }

    public function acaoVerificarnova() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->visao->viagens = (new viagemDAO())->consultar("idViagem,nomeCurso,concat_ws(' - ',dataIda,horaIda) as ida,concat_ws(' - ',dataVolta,horaVolta) as volta,motivo,estadoViagem,diarias,concat(IFNULL(nomePolo,''),IFNULL(outroDestino,'')) as destino");
        $i = 0;
        foreach ($this->visao->viagens as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->viagens[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoEditar() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
       /* if (filter_has_var(INPUT_GET, 'viagemID') || filter_has_var(INPUT_POST, 'viagemID')) {
            $idViagem = fnDecrypt($_REQUEST['viagemID']); //TODO mudar para filter_input() quando INPUT_REQUEST estiver implementado no PHP
            $viagemDAO = new viagemDAO();
            $this->visao->viagemID = $_REQUEST['viagemID'];
            $viagem = $viagemDAO->recuperarviagem($idviagem);
            $this->visao->comboBoxAreas = ComboBoxAreas::montarTodasAsAreas();
            $this->visao->descricao = $livro->get_descricao();
            $this->visao->livro = $livro->get_nomelivro();
            $this->visao->quantidade = $livro->get_quantidade();
            $this->visao->dataEntrada = $livro->get_dataEntrada();
            $this->visao->numeroPatrimonio = $livro->get_numeroPatrimonio();
            $this->visao->grafica = $livro->get_grafica();
            $this->visao->area = $livro->get_area();
        } else {
            die("Acesso indevido");
        }*/
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Ferramenta::CONTROLE_VIAGENS;
    }

    

}

?>
