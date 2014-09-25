<?php

namespace app\controlador;

include_once APP_LIBRARY_ABSOLUTE_DIR . 'Mvc/Controlador.php';
require_once APP_LIBRARY_ABSOLUTE_DIR . "seguranca/criptografia.php";
require_once APP_DIR . "modelo/dao/ImagensDAO.php";
require_once APP_DIR . "modelo/comboboxes/ComboBoxDescritores.php";
require_once APP_DIR . "modelo/comboboxes/ComboBoxUsuarios.php";
require_once APP_DIR . "modelo/ferramentas/imagens/pesquisa.php";
require_once APP_DIR . "modelo/enumeracao/Ferramenta.php";
require_once APP_DIR . "modelo/enumeracao/Papel.php";

use \app\modelo as Modelo;
use \app\mvc as MVC;

class ControladorImagens extends MVC\Controlador {
    /*
     * IMAGEM
     */

    public function acaoBuscar() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;

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

            if (filter_has_var(INPUT_GET, 'u')) {
                if (filter_input(INPUT_GET, 'u') != "default") {
                    $idAutor = fnDecrypt(filter_input(INPUT_GET, 'u'));
                } else {
                    $idAutor = null;
                }
            } else {
                $idAutor = null;
            }

            if (filter_has_var(INPUT_GET, 'de')) {
                //TODO filtrar com FILTER_FLAG_EMPTY_STRING_NULL quando estiver implementado pelo PHP
                $de = filter_input(INPUT_GET, 'de');
                $dataInicio = !empty($de) ? filter_input(INPUT_GET, 'de') : null;
            } else {
                $dataInicio = null;
            }

            if (filter_has_var(INPUT_GET, 'ate')) {
                $ate = filter_input(INPUT_GET, 'ate');
                $dataFim = !empty($ate) ? filter_input(INPUT_GET, 'ate') : null;
            } else {
                $dataFim = null;
            }
            $termo = filter_input(INPUT_GET, 'q');
            $pesquisa = new Modelo\ferramentas\imagens\pesquisa();
            $acessoTotal = $papel <= Modelo\Papel::GESTOR;
//            if ($termo == "") {
//                $pesquisa->obterTodas($pagina, $itensPorPagina, $acessoTotal);
//            } else {
            $pesquisa->buscar($termo, $pagina, $itensPorPagina, $acessoTotal, $idAutor, $dataInicio, $dataFim);
//            }
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
        $this->visao->tempoGasto = $pesquisa->obterTempoGasto();
        $this->renderizar();
    }

    public function acaoConsultarimagem() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->visao->acessoTotal = obterUsuarioSessao()->get_idPapel() <= Modelo\Papel::GESTOR;
        $this->visao->todosUsuarios = Modelo\ComboBoxUsuarios::listarTodosUsuarios(Modelo\ComboBoxUsuarios::LISTAR_COM_CPF, "");
        $this->renderizar();
    }

    public function acaoNovaImagem() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->visao->cpfAutor = obterUsuarioSessao()->get_cpf();
        $this->visao->iniciaisAutor = obterUsuarioSessao()->get_iniciais();
        $this->visao->comboBoxDescritor = Modelo\ComboBoxDescritores::montarDescritorPrimeiroNivel();
        $this->visao->nomeUsuario = obterUsuarioSessao()->get_PNome() . ' ' . obterUsuarioSessao()->get_UNome();
        $this->renderizar();
    }

    public function acaoVerificarnovaimagem() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoCriarthumb() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoBaixarimagem() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoBaixarvetorial() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoVisualizarimagem() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->renderizar();
    }

    /*
     * DESCRITORES
     */

    public function acaoObterdescritores() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoDescritores() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoNovodescritor() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->visao->comboBoxDescritor = Modelo\ComboBoxDescritores::montarDescritorPrimeiroNivel();
        $this->renderizar();
    }

    public function acaoGerenciardescritores() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $imagensDAO = new Modelo\imagensDAO();
        $this->visao->descritores = $imagensDAO->consultarDescritor('*', 'qtdFilhos = 0');
        $this->renderizar();
    }

    public function acaoVerificarnovodescritor() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoVerificaredicaodescritor() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoObterdescritor() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoAuxcombonivel1() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoRenomearDescritor() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoCriarDescritor() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoMoverDescritor() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoRemoverDescritor() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    /*
     * OUTROS
     */

    public function acaoArvoreDescritores() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Modelo\Ferramenta::GALERIA_IMAGENS;
    }

}
