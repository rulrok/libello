<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
require_once APP_DIR. 'modelo/enumeracao/Ferramenta.php';

class ControladorProcessos extends Controlador {
    function acaoCaixaProcessos(){
        $this->renderizar();
    } 
    
    function acaoClick(){ 
        $this->renderizar();
    }
    
     public function acaoBuscar() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;

        $papel = obterUsuarioSessao()->get_idPapel();

        if (filter_has_var(INPUT_GET, 'q')) {
            if (filter_has_var(INPUT_GET, 'p')) {
                $pagina = filter_input(INPUT_GET, 'p');
            } else {
                $pagina = 1;
            }
            if (filter_has_var(INPUT_GET, 'l')) {
                $itensPorPagina = filter_input(INPUT_GET, 'l');
            } else {
                $itensPorPagina = 10;
            }
            $termo = filter_input(INPUT_GET, 'q');
            $pesquisa = new pesquisa();
            $acessoTotal = $papel <= Papel::GESTOR;
            if ($termo == "") {
                $pesquisa->obterTodas($pagina, $itensPorPagina, $acessoTotal);
            } else {
                $pesquisa->buscar($termo, $pagina, $itensPorPagina, $acessoTotal);
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

    public function acaoConsultarimagem() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoNovaImagem() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->visao->cpfAutor = obterUsuarioSessao()->get_cpf();
        $this->visao->iniciaisAutor = obterUsuarioSessao()->get_iniciais();
        $this->visao->comboBoxDescritor = ComboBoxDescritores::montarDescritorPrimeiroNivel();
        $this->visao->nomeUsuario = obterUsuarioSessao()->get_PNome() . ' ' . obterUsuarioSessao()->get_UNome();
        $this->renderizar();
    }

    public function acaoVerificarnovaimagem() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoCriarthumb() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoBaixarimagem() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoBaixarvetorial() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->renderizar();
    }

    /*
     * DESCRITORES
     */

    public function acaoObterdescritores() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoDescritores() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoNovodescritor() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->visao->comboBoxDescritor = ComboBoxDescritores::montarDescritorPrimeiroNivel();
        $this->renderizar();
    }

    public function acaoGerenciardescritores() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $processosDAO = new processosDAO();
        $this->visao->descritores = $processosDAO->consultarDescritor('*', 'qtdFilhos = 0');
        $this->renderizar();
    }

    public function acaoVerificarnovodescritor() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoVerificaredicaodescritor() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoObterdescritor() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoAuxcombonivel1() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoRenomearDescritor() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoCriarDescritor() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoMoverDescritor() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoRemoverDescritor() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    /*
     * OUTROS
     */

    public function acaoArvoreProcessos() {
        $processosDAO = new processosDAO();
        if (filter_has_var(INPUT_GET, 'completa') && filter_input(INPUT_GET, 'completa')) {
            if (filter_has_var(INPUT_GET, 'descritorExcluir')) {
                $descritorExcluido = fnDecrypt(filter_input(INPUT_GET, 'descritorExcluir'));
            } else {
                $descritorExcluido = null;
            }
            $this->visao->arvore = $processosDAO->arvoreProcessos(true, $descritorExcluido);
        } else {
            $this->visao->arvore = $processosDAO->arvoreProcessos();
        }
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Ferramenta::PROCESSOS;
    }

}
