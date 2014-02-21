<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
require_once APP_LOCATION . "modelo/ComboBoxCategoriasAfins.php";
require_once APP_LOCATION . "modelo/ComboBoxDificuldades.php";
require_once BIBLIOTECA_DIR . "seguranca/criptografia.php";
require_once APP_LOCATION . "modelo/ferramentas/imagens/pesquisa.php";

class ControladorImagens extends Controlador {
    /*
     * IMAGEM
     */

    public function acaoBusca() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;

        if (filter_has_var(INPUT_GET, 'q')) {
            if (filter_has_var(INPUT_GET, 'p')) {
                $pagina = filter_input(INPUT_GET, 'p');
            } else {
                $pagina = 1;
            }
            $termo = filter_input(INPUT_GET, 'q');
            $pesquisa = new pesquisa();
            if ($termo == "") {
                $pesquisa->obterTodas($pagina);
            } else {
                $pesquisa->buscar($termo, $pagina);
            }
            if ($pesquisa->temResultados()) {
                $this->visao->temResultados = true;
                $this->visao->resultados = $pesquisa->obterResultados();
                $this->visao->paginacao = $pesquisa->obterPaginacao();
            } else {
                $this->visao->temResultados = false;
                $this->visao->resultados = array();
                $this->visao->paginacao = null;
            }
        } else {
            if (filter_has_var(INPUT_GET, 'p')) {
                $pagina = filter_input(INPUT_GET, 'p');
            } else {
                $pagina = 1;
            }
            $termo = filter_input(INPUT_GET, 'q');
            $pesquisa = new pesquisa();
            $pesquisa->obterTodas($pagina);
            if ($pesquisa->temResultados()) {
                $this->visao->temResultados = true;
                $this->visao->resultados = $pesquisa->obterResultados();
                $this->visao->paginacao = $pesquisa->obterPaginacao();
            } else {
                $this->visao->temResultados = false;
                $this->visao->resultados = array();
                $this->visao->paginacao = null;
            }
        }
        $this->renderizar();
    }

    public function acaoConsultar() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoNovaImagem() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->visao->cpfAutor = obterUsuarioSessao()->get_cpf();
        $this->visao->iniciaisAutor = obterUsuarioSessao()->get_iniciais();
        $this->visao->comboBoxCategorias = ComboBoxCategoriasAfins::montarDescritorPrimeiroNivel();
//        $this->visao->comboBoxComplexidades = ComboBoxDificuldades::montarTodasAsComplexidades();
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

    public function acaoCriarthumb() {
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

    
    public function acaoGerenciarDescritores(){
        $this->renderizar();
    }
    /*
     * CATEGORIAS
     */

    public function acaoNovaCategoria() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoDescritores() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoGerenciarCategorias() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->visao->categorias = imagensDAO::consultarDescritoresPais("idCategoria, nomeCategoria");
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
        if (filter_has_var(INPUT_GET | INPUT_POST, 'categoriaID')) {
            $categoriaID = fnDecrypt(filter_input(INPUT_GET | INPUT_POST, 'categoriaID'));
            $this->visao->categoriaID = filter_input(INPUT_GET | INPUT_POST, 'categoriaID');
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

    public function acaoObterdescritor() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoNovaSubcategoria() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->visao->comboBoxCategoriaPai = ComboBoxCategoriasAfins::montarDescritorPrimeiroNivel(true, 'input-large', 'categoriapai', 'categoriapai');
        $this->renderizar();
    }

    public function acaoGerenciarSubcategorias() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->visao->subcategorias = imagensDAO::consultarDescritoresFilhos("idSubcategoria, nomeSubcategoria, nomeCategoria", null, " JOIN imagens_categoria cat ON categoriaPai = cat.idCategoria");
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
        if (filter_has_var(INPUT_GET | INPUT_POST, 'subcategoriaID')) {
            $categoriaID = fnDecrypt(filter_input(INPUT_GET | INPUT_POST, 'subcategoriaID'));
            $this->visao->subcategoriaID = filter_input(INPUT_GET | INPUT_POST, 'subcategoriaID');
            $curso = imagensDAO::recuperarSubcategoria($categoriaID);
            $this->visao->subcategoria = $curso->get_nomeSubcategoria();
            $this->visao->categoriapaiID = fnEncrypt((int) $curso->get_categoriaPai());
            $this->visao->comboBoxCategoriaPai = ComboBoxCategoriasAfins::montarDescritorPrimeiroNivel(true, 'input-large', 'categoriapai', 'categoriapai');
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