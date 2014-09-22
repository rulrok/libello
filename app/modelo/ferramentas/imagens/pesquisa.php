<?php

namespace app\modelo\ferramentas\imagens;

require_once APP_DIR . "modelo/dao/imagensDAO.php";

use \app\modelo as Modelo;

class pesquisa {

    var $paginacao;
    var $resultados;
    var $temResultados;
    var $tempoInicial;
    var $tempoFinal;

    public function temResultados() {
//        if ($this->paginacao != null && !empty($this->resultados)) {
//            return true;
//        }
//        return false;
        return $this->temResultados;
    }

    private function _ofuscarIds() {
        foreach ($this->resultados as $key => $value) {
            $this->resultados[$key]['idImagem'] = fnEncrypt($value['idImagem']);
            $this->resultados[$key][0] = $this->resultados[$key]['idImagem'];
        }
    }

    private function _processarTipos() {

        function getExtension($str) {
            $i = strrpos($str, ".");
            if (!$i) {
                return "";
            }
            $l = strlen($str) - $i;
            $ext = substr($str, $i + 1, $l);
            return $ext;
        }

        foreach ($this->resultados as $key => $value) {
            $this->resultados[$key]['tipo'] = getExtension($value['nomeArquivo']);
        }
    }

    private function _criarPaginacao($pagina, $ultimaPagina) {
        $centerPages = "";
        $centerPages .= '<div class="pagination pagination-centered "><ul>';
        $ant = $pagina - 1;
        $prox = $pagina + 1;
        if ($pagina > 1) {
            $centerPages .= "<li><a href='javascript:buscar($ant)'>&laquo; Anterior</a></li>";
            $centerPages .= "<li><a href=javascript:buscar(1)>1</a></li> ";
        } else {
            $centerPages .= '<li class="disabled"><span>&laquo; Anterior</span></li>';
            $centerPages .= "<li class='active'><span>1</span></li> ";
        }
        if ($pagina - 3 > 1) {
            $centerPages .= ' <li class="disabled"><span> &hellip; </span></li> ';
            $i = max([$pagina - 2, 2]);
            $f = min([$pagina + 2, $ultimaPagina - 1]);
        } else {
            $i = max([$pagina - 3, 2]);
            $f = min([$pagina + 3, $ultimaPagina - 1]);
        }
        for (; $i <= $f; $i++) {
            if ($i != $pagina) {
                $centerPages .= "<li><a href='javascript:buscar($i)'>$i</a></li> ";
            } else {
                $centerPages .= "<li class='active'><span>$i</span></li> ";
            }
        }
        if ($ultimaPagina > $pagina + 3) {
            $centerPages .= ' <li class="disabled"><span> &hellip; </span></li> ';
        }

        if ($ultimaPagina != $pagina) {
            $centerPages .= "<li><a href='javascript:buscar($ultimaPagina)'>$ultimaPagina</a></li>";
            $centerPages .= "<li><a href='javascript:buscar($prox)'>Próximo &raquo;</a></li>";
        } else {
            if ($ultimaPagina != 1) {
                $centerPages .= "<li class='active'><span>$ultimaPagina</span></li>";
            }
            $centerPages .= '<li class="disabled"><span>Próximo &raquo;</span></li>';
        }
        $centerPages .= '</ul></div>';

//        $this->paginacao .= 'Página <strong>' . $pagina . '</strong> de ' . $ultimaPagina . '     ';
        $this->paginacao .= '<span class="paginationNumbers">' . $centerPages . '</span>';
    }

    public function obterTodas($pagina, $itensPorPagina = 10, $acessoTotal = false, $autor = null) {
        return $this->buscar('', $pagina, $itensPorPagina, $acessoTotal, $autor);
    }

    /**
     * 
     * @param type $termoBusca
     * @param type $pagina
     * @param type $itensPorPagina
     * @param type $acessoTotal
     * @param type $autor id do usuario autor
     * @param type $dataInicio Unix timestamp
     * @param type $dataFim Unix timestamp
     * @return type
     */
    public function buscar($termoBusca, $pagina, $itensPorPagina = 10, $acessoTotal = false, $autor = null, $dataInicio = null, $dataFim = null) {
        $this->tempoInicial = microtime(true);
        $imagensDAO = new Modelo\imagensDAO();
        $res1 = $imagensDAO->pesquisarImagem($termoBusca, null, $acessoTotal, $autor, $dataInicio, $dataFim);
        $nr = sizeof($res1);
        $this->temResultados = ($nr != 0);
        if (!$this->temResultados) {
            $this->paginacao = null;
            $this->resultados = array();
            $this->tempoFinal = microtime(true);
            return;
        }

        $pagina = preg_replace('#[^0-9]#i', '', $pagina);

        $ultimaPagina = ceil($nr / $itensPorPagina);

        if ($pagina < 1) {
            $pagina = 1;
        } else if ($pagina > $ultimaPagina) {
            $pagina = $ultimaPagina;
        }

        $limite = ' LIMIT ' . ($pagina - 1) * $itensPorPagina . ',' . $itensPorPagina;

        $this->resultados = $imagensDAO->pesquisarImagem($termoBusca, $limite, $acessoTotal, $autor, $dataInicio, $dataFim);

        $this->_criarPaginacao($pagina, $ultimaPagina);
        $this->_ofuscarIds();
        $this->_processarTipos();
        $this->tempoFinal = microtime(true);
    }

    public function obterResultados() {
        return $this->resultados;
    }

    public function obterPaginacao() {
        return $this->paginacao;
    }

    public function obterTempoGasto() {
        return number_format($this->tempoFinal - $this->tempoInicial, 5);
    }

}
