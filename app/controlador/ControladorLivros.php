<?php

namespace app\controlador;

include_once APP_LIBRARY_DIR . 'Mvc/Controlador.php';
require_once APP_DIR . "modelo/dao/LivroDAO.php";
require_once APP_DIR . "modelo/comboboxes/ComboBoxPapeis.php";
require_once APP_DIR . "modelo/comboboxes/ComboBoxUsuarios.php";
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPolo.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxAreas.php';
require_once APP_LIBRARY_DIR . "seguranca/criptografia.php";
require_once APP_LIBRARY_DIR . "seguranca/Permissao.php";

use \app\modelo as Modelo;
use \app\mvc as MVC;

class ControladorLivros extends MVC\Controlador {

    var $tipoPadrao = "custeio";

    public function acaoNovo() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->visao->comboBoxAreas = Modelo\ComboBoxAreas::montarTodasAsAreas();
        $this->renderizar();
    }

    public function acaoVerificarNovo() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoConsultar() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoConsultar_interno() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->visao->livrosInternos = (new Modelo\livroDAO())->consultar("nomelivro,grafica,nomeArea,quantidade,dataEntrada,numeroPatrimonio");
        $this->renderizar();
    }

    public function acaoConsultar_externo() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->visao->livrosExternos = (new Modelo\livroDAO())->consultarSaidas("nomelivro,grafica,nomeArea,quantidadeSaida,dataEntrada,numeroPatrimonio");
        $this->renderizar();
    }

    public function acaoConsultar_embaixa() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->visao->livrosBaixa = (new Modelo\livroDAO())->consultarBaixas("nomelivro,grafica,nomeArea,quantidadeBaixa,dataBaixa,numeroPatrimonio,observacoes");
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->visao->livros = (new Modelo\livroDAO())->consultar("idLivro,nomelivro,grafica,nomeArea,quantidade,dataEntrada,numeroPatrimonio,descricao");
        $i = 0;
        foreach ($this->visao->livros as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->livros[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoEditar() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        if (filter_has_var(INPUT_GET, 'livroID') || filter_has_var(INPUT_POST, 'livroID')) {
            $idlivro = fnDecrypt($_REQUEST['livroID']); //TODO mudar para filter_input() quando INPUT_REQUEST estiver implementado no PHP
            $livroDAO = new Modelo\livroDAO();
            $this->visao->livroEditavel = $livroDAO->livroPodeTerTipoAlterado($idlivro);
            $this->visao->livroID = $_REQUEST['livroID'];
            $livro = $livroDAO->recuperarlivro($idlivro);
            $this->visao->comboBoxAreas = Modelo\ComboBoxAreas::montarTodasAsAreas();
            $this->visao->descricao = $livro->get_descricao();
            $this->visao->livro = $livro->get_nomelivro();
            $this->visao->quantidade = $livro->get_quantidade();
            $this->visao->dataEntrada = $livro->get_dataEntrada();
            $this->visao->numeroPatrimonio = $livro->get_numeroPatrimonio();
            $this->visao->grafica = $livro->get_grafica();
            $this->visao->area = $livro->get_area();
        } else {
            die("Acesso indevido");
        }

        $this->renderizar();
    }

    public function acaoVerificarEdicao() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoRemover() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoRetorno() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->visao->saidas = (new Modelo\livroDAO())->consultarSaidas("idSaida, nomelivro, numeroPatrimonio, concat_ws(' ',PNome,UNome) AS `responsavel`, coalesce(destino,nomePolo),quantidadeSaida,dataSaida");
        $i = 0;
        foreach ($this->visao->saidas as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->saidas[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoNovoretorno() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        if (filter_has_var(INPUT_GET, 'saidaID') || filter_has_var(INPUT_POST, 'saidaID')) {
            $idSaida = fnDecrypt($_REQUEST['saidaID']);
            $livroDAO = new Modelo\livroDAO();
            $saida = $livroDAO->recuperarSaidalivro($idSaida);
            $livroID = $saida['livro'];
            $livro = $livroDAO->recuperarlivro($livroID);
            $this->visao->saidaID = fnEncrypt($idSaida);
            $this->visao->livroID = fnEncrypt($livroID);
            $this->visao->livro = $livro;
            $this->visao->quantidadeMaxima = $saida['quantidadeSaida'];
            $this->visao->dataSaida = $saida['dataSaida'];
            $this->renderizar();
        } else {
            die("Acesso indevido");
        }
    }

    public function acaoRegistrarretorno() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoSaida() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->visao->livros = (new Modelo\livroDAO())->consultar("idlivro,nomelivro,quantidade,dataEntrada,numeroPatrimonio", "quantidade > 0");
        $i = 0;
        foreach ($this->visao->livros as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->livros[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoNovasaida() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        if (filter_has_var(INPUT_GET, 'livroID')) {
            $this->visao->comboboxPapeis = Modelo\ComboBoxPapeis::montarTodosPapeis();
            $this->visao->livro = (new Modelo\livroDAO())->recuperarlivro(fnDecrypt(filter_input(INPUT_GET, 'livroID')));
            $this->visao->livroID = fnEncrypt($this->visao->livro->get_idLivro());
            //$this->visao->responsavel = Modelo\ComboBoxUsuarios::montarResponsavelLivros();
            $this->visao->responsavel = Modelo\ComboBoxUsuarios::listarTodosUsuarios();
            $this->visao->polos = Modelo\ComboBoxPolo::montarTodosOsPolos();
            $this->renderizar();
        } else {
            die("Acesso indevido.");
        }
    }

    public function acaoRegistrarsaida() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoListarusuarios() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoNovabaixa() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        if (filter_has_var(INPUT_GET, 'livroID')) {
            $livroDAO = new Modelo\livroDAO();
            $livro = $livroDAO->recuperarlivro(fnDecrypt(filter_input(INPUT_GET, 'livroID')));
            $this->visao->livro = $livro;
            $this->visao->dataMinima = $livro->get_dataEntrada();
            if ($this->visao->dataMinima == "") {
                $this->visao->dataMinima = "01/01/1900";
            }
            $this->visao->livroID = fnEncrypt($this->visao->livro->get_idlivro());
            $this->visao->quantidadeMaxima = $livro->get_quantidade();
            $this->visao->saidaID = '';
            $this->renderizar();
        } else if (filter_has_var(INPUT_GET, 'saidaID')) {
            $livroDAO = new Modelo\livroDAO();
            $saida = $livroDAO->recuperarSaidalivro(fnDecrypt(filter_input(INPUT_GET, 'saidaID')));
            $this->visao->dataMinima = $saida['dataSaida'];
            $this->visao->livro = $livroDAO->recuperarlivro($saida['livro']);
            $this->visao->livroID = fnEncrypt($this->visao->livro->get_idlivro());
            $this->visao->quantidadeMaxima = $saida['quantidadeSaida'];
            $this->visao->saidaID = filter_input(INPUT_GET, 'saidaID');
            $this->renderizar();
        } else {
            die("Acesso indevido.");
        }
    }

    public function acaoRegistrarbaixa() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoGerenciarbaixasesaidas() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoGerenciar_baixas() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->visao->baixas = (new Modelo\livroDAO())->consultarBaixas("idBaixa,nomelivro,dataBaixa,quantidadeBaixa,saida,observacoes");
        $i = 0;
        foreach ($this->visao->baixas as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->baixas[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoRemover_baixa() {
        $this->visao->acessoMinimo = Modelo\Permissao::ADMINISTRADOR;
        $this->renderizar();
    }

    public function acaoGerenciar_saidas() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->visao->saidas = (new Modelo\livroDAO())->consultarSaidas("idSaida,nomelivro,grafica,dataSaida,quantidadeSaidaOriginal,coalesce(destino,nomePolo),concat_ws(' ',PNome,UNome) as `responsavel`");
        $i = 0;
        foreach ($this->visao->saidas as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->saidas[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoRemover_saida() {
        $this->visao->acessoMinimo = Modelo\Permissao::ADMINISTRADOR;
        $this->renderizar();
    }

    public function acaoRelatorios() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Modelo\Ferramenta::CONTROLE_LIVROS;
    }

}

?>
