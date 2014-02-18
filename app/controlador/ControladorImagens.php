<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
require_once APP_LOCATION . "modelo/ComboBoxCategoriasAfins.php";
require_once APP_LOCATION . "modelo/ComboBoxDificuldades.php";
require_once BIBLIOTECA_DIR . "seguranca/criptografia.php";

class ControladorImagens extends Controlador {
    /*
     * IMAGEM
     */

    public function acaoConsultar() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoNovaImagem() {
        $this->visao->comboBoxCategorias = ComboBoxCategoriasAfins::montarTodasAsCategorias();
        $this->visao->comboBoxDificuldades = ComboBoxDificuldades::montarTodasAsDificuldades();
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoVerificarnovaimagem() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoUpload_img() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoProcessarimagem() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    /*
     * GALERIAS
     */

    public function acaoGerenciargalerias() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    /*
     * CATEGORIAS
     */

    public function acaoNovaCategoria() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoCategoriaseafins() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoGerenciarCategorias() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->visao->categorias = imagensDAO::consultarCategorias("idCategoria, nomeCategoria");
        $i = 0;
        foreach ($this->visao->categorias as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->categorias[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoVerificarnovacategoria() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoEditarcategoria() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        if (isset($_GET['categoriaID']) || isset($_POST['categoriaID'])) {
            $categoriaID = fnDecrypt($_REQUEST['categoriaID']);
            $this->visao->categoriaID = $_REQUEST['categoriaID'];
            $curso = imagensDAO::recuperarCategoria($categoriaID);
            $this->visao->categoria = $curso->get_nomeCategoria();
        } else {
            die("Acesso indevido");
        }
        $this->renderizar();
    }

    public function acaoVerificaredicaocategoria() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoRemoverCategoria() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    /*
     * SUB-CATEGORIAS
     */

    public function acaoObterSubcategorias() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoNovaSubcategoria() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->visao->comboBoxCategoriaPai = ComboBoxCategoriasAfins::montarTodasAsCategorias(true, 'input-large', 'categoriapai', 'categoriapai');
        $this->renderizar();
    }

    public function acaoGerenciarSubcategorias() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->visao->subcategorias = imagensDAO::consultarSubcategorias("idSubcategoria, nomeSubcategoria, nomeCategoria", null, " JOIN imagens_categoria cat ON categoriaPai = cat.idCategoria");
        $i = 0;
        foreach ($this->visao->subcategorias as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->subcategorias[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoVerificarnovasubcategoria() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoEditarsubcategoria() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        if (isset($_GET['subcategoriaID']) || isset($_POST['subcategoriaID'])) {
            $categoriaID = fnDecrypt($_REQUEST['subcategoriaID']);
            $this->visao->subcategoriaID = $_REQUEST['subcategoriaID'];
            $curso = imagensDAO::recuperarSubcategoria($categoriaID);
            $this->visao->subcategoria = $curso->get_nomeSubcategoria();
            $this->visao->categoriapaiID = fnEncrypt((int) $curso->get_categoriaPai());
            $this->visao->comboBoxCategoriaPai = ComboBoxCategoriasAfins::montarTodasAsCategorias(true, 'input-large', 'categoriapai', 'categoriapai');
        } else {
            die("Acesso indevido");
        }
        $this->renderizar();
    }

    public function acaoVerificaredicaosubcategoria() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoRemoverSubcategoria() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    /*
     * OUTROS
     */

    public function idFerramentaAssociada() {
        return Ferramenta::GALERIA_IMAGENS;
    }

}

?>
