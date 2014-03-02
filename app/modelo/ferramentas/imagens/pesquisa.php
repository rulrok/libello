<?php

require_once APP_LOCATION . "modelo/dao/imagensDAO.php";

class pesquisa {

    var $paginacao;
    var $resultados;
    var $temResultados;

    public function temResultados() {
//        if ($this->paginacao != null && !empty($this->resultados)) {
//            return true;
//        }
//        return false;
        return $this->temResultados;
    }

    private function criarPaginacao($pagina, $ultimaPagina) {
        $centerPages = "";
        $sub1 = $pagina - 1;
        $sub2 = $pagina - 2;
        $add1 = $pagina + 1;
        $add2 = $pagina + 2;

        if ($pagina == 1) {
            $centerPages .= '&nbsp; <span class="pagNumActive">' . $pagina . '</span> &nbsp;';
            $centerPages .= '&nbsp; <a href="' . filter_input(INPUT_SERVER, 'PHP_SELF') . '?p=' . $add1 . '">' . $add1 . '</a> &nbsp;';
        } else if ($pagina == $ultimaPagina) {
            $centerPages .= '&nbsp; <a href="' . filter_input(INPUT_SERVER, 'PHP_SELF') . '?p=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="pagNumActive">' . $pagina . '</span> &nbsp;';
        } else if ($pagina > 2 && $pagina < ($ultimaPagina - 1)) {
            $centerPages .= '&nbsp; <a href="' . filter_input(INPUT_SERVER, 'PHP_SELF') . '?p=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <a href="' . filter_input(INPUT_SERVER, 'PHP_SELF') . '?p=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="pagNumActive">' . $pagina . '</span> &nbsp;';
            $centerPages .= '&nbsp; <a href="' . filter_input(INPUT_SERVER, 'PHP_SELF') . '?p=' . $add1 . '">' . $add1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <a href="' . filter_input(INPUT_SERVER, 'PHP_SELF') . '?p=' . $add2 . '">' . $add2 . '</a> &nbsp;';
        } else if ($pagina > 1 && $pagina < $ultimaPagina) {
            $centerPages .= '&nbsp; <a href="' . filter_input(INPUT_SERVER, 'PHP_SELF') . '?p=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
            $centerPages .= '&nbsp; <span class="pagNumActive">' . $pagina . '</span> &nbsp;';
            $centerPages .= '&nbsp; <a href="' . filter_input(INPUT_SERVER, 'PHP_SELF') . '?p=' . $add1 . '">' . $add1 . '</a> &nbsp;';
        }


//        if ($ultimaPagina != "1") {
        // This shows the user what page they are on, and the total number of pages
        $this->paginacao .= 'Page <strong>' . $pagina . '</strong> of ' . $ultimaPagina . '&nbsp;  &nbsp;  &nbsp; ';
        // If we are not on page 1 we can place the Back button
        if ($pagina != 1) {
            $previous = $pagina - 1;
            $this->paginacao .= '&nbsp;  <a href="' . filter_input(INPUT_SERVER, 'PHP_SELF') . '?p=' . $previous . '"> Back</a> ';
        }
        // Lay in the clickable numbers display here between the Back and Next links
        $this->paginacao .= '<span class="paginationNumbers">' . $centerPages . '</span>';
        // If we are not on the very last page we can place the Next button
        if ($pagina != $ultimaPagina) {
            $nextPage = $pagina + 1;
            $this->paginacao .= '&nbsp;  <a href="' . filter_input(INPUT_SERVER, 'PHP_SELF') . '?p=' . $nextPage . '"> Next</a> ';
        }
    }

    public function obterTodas($pagina, $itensPorPagina = 10) {
        $imagensDAO = new imagensDAO();
        $res1 = $imagensDAO->consultarTodasAsImagens();
        $nr = sizeof($res1);
        $this->temResultados = ($nr != 0);
        if (!$this->temResultados) {
            $this->paginacao = null;
            $this->resultados = array();
            exit;
        }

        $pagina = preg_replace('#[^0-9]#i', '', $pagina);

        $ultimaPagina = ceil($nr / $itensPorPagina);

        if ($pagina < 1) {
            $pagina = 1;
        } else if ($pagina > $ultimaPagina) {
            $pagina = $ultimaPagina;
        }

        $limite = 'LIMIT ' . ($pagina - 1) * $itensPorPagina . ',' . $itensPorPagina;

        $this->resultados = $imagensDAO->consultarTodasAsImagens($limite);

        $this->criarPaginacao($pagina, $ultimaPagina);
    }

    public function buscar($termoBusca, $pagina, $itensPorPagina = 10) {
        $imagensDAO = new imagensDAO();
        $res1 = $imagensDAO->pesquisarImagem($termoBusca);
        $nr = sizeof($res1);
        $this->temResultados = ($nr != 0);
        if (!$this->temResultados) {
            $this->paginacao = null;
            $this->resultados = array();
            exit;
        }

        $pagina = preg_replace('#[^0-9]#i', '', $pagina);

        $ultimaPagina = ceil($nr / $itensPorPagina);

        if ($pagina < 1) {
            $pagina = 1;
        } else if ($pagina > $ultimaPagina) {
            $pagina = $ultimaPagina;
        }

        $limite = 'LIMIT ' . ($pagina - 1) * $itensPorPagina . ',' . $itensPorPagina;

        $this->resultados = $imagensDAO->pesquisarImagem($termoBusca, $limite);

        $this->criarPaginacao($pagina, $ultimaPagina);
//        }
    }

    public function obterResultados() {
        return $this->resultados;
    }

    public function obterPaginacao() {
        return $this->paginacao;
    }

}
