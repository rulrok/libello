<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';
require_once APP_LOCATION . "modelo/ComboBoxPapeis.php";
require_once APP_LOCATION . "modelo/ComboBoxUsuarios.php";
include_once APP_LOCATION . 'modelo/ComboBoxPolo.php';
include_once APP_LOCATION . 'modelo/ComboBoxAreas.php';
require_once BIBLIOTECA_DIR . "seguranca/criptografia.php";
require_once BIBLIOTECA_DIR . "seguranca/Permissao.php";

class ControladorLivros extends Controlador {

    var $tipoPadrao = "custeio";

    public function acaoNovo() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->visao->comboBoxAreas = ComboBoxAreas::montarTodasAsAreas();
        $this->renderizar();
    }

    public function acaoVerificarNovo() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoConsultar() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoConsultar_interno() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->visao->livrosInternos = livroDAO::consultar("nomelivro,grafica,nomeArea,quantidade,dataEntrada,numeroPatrimonio");
        $this->renderizar();
    }

    public function acaoConsultar_externo() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->visao->livrosExternos = livroDAO::consultarSaidas("nomelivro,grafica,nomeArea,quantidadeSaida,dataEntrada,numeroPatrimonio");
        $this->renderizar();
    }

    public function acaoConsultar_embaixa() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->visao->livrosBaixa = livroDAO::consultarBaixas("nomelivro,grafica,nomeArea,quantidadeBaixa,dataBaixa,numeroPatrimonio,observacoes");
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->visao->livros = livroDAO::consultar("idLivro,nomelivro,grafica,nomeArea,quantidade,dataEntrada,numeroPatrimonio,descricao");
        $i = 0;
        foreach ($this->visao->livros as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->livros[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoEditar() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        if (isset($_GET['livroID']) || isset($_POST['livroID'])) {
            $idlivro = fnDecrypt($_REQUEST['livroID']);
            $this->visao->livroEditavel = livroDAO::livroPodeTerTipoAlterado($idlivro);
            $this->visao->livroID = $_REQUEST['livroID'];
            $livro = livroDAO::recuperarlivro($idlivro);
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
        }

        $this->renderizar();
    }

    public function acaoVerificarEdicao() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoRemover() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoRetorno() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->visao->saidas = livroDAO::consultarSaidas("idSaida, nomelivro, numeroPatrimonio, concat(PNome,' ',UNome) AS `responsavel`,destino,nomePolo,quantidadeSaida,dataSaida");
        $i = 0;
        foreach ($this->visao->saidas as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->saidas[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoNovoretorno() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        if (isset($_GET['saidaID']) || isset($_POST['saidaID'])) {
            $idSaida = fnDecrypt($_GET['saidaID']);

            $saida = livroDAO::recuperarSaidalivro($idSaida);

            $livroID = $saida['livro'];
            $livro = livroDAO::recuperarlivro($livroID);

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
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoSaida() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->visao->livros = livroDAO::consultar("idlivro,nomelivro,quantidade,dataEntrada,numeroPatrimonio", "quantidade > 0");
        $i = 0;
        foreach ($this->visao->livros as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->livros[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoNovasaida() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        if (isset($_GET['livroID'])) {
            $this->visao->comboboxPapeis = ComboBoxPapeis::montarComboBoxPadrao();
            $this->visao->livro = livroDAO::recuperarlivro(fnDecrypt($_GET['livroID']));
            $this->visao->livroID = fnEncrypt($this->visao->livro->get_idLivro());
            $this->visao->responsavel = ComboBoxUsuarios::montarResponsavelViagem();
            $this->visao->polos = ComboBoxPolo::montarTodosOsPolos();
            $this->renderizar();
        } else {
            die("Acesso indevido.");
        }
    }

    public function acaoRegistrarsaida() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoListarusuarios() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoNovabaixa() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        if (isset($_GET['livroID'])) {
            $livro = livroDAO::recuperarlivro(fnDecrypt($_GET['livroID']));
            $this->visao->livro = $livro;
            $this->visao->dataMinima = $livro->get_dataEntrada();
            if ($this->visao->dataMinima == "") {
                $this->visao->dataMinima = "01/01/1900";
            }
            $this->visao->livroID = fnEncrypt($this->visao->livro->get_idlivro());
            $this->visao->quantidadeMaxima = $livro->get_quantidade();
            $this->visao->saidaID = '';
            $this->renderizar();
        } else if (isset($_GET['saidaID'])) {
            $saida = livroDAO::recuperarSaidalivro(fnDecrypt($_GET['saidaID']));
            $this->visao->dataMinima = $saida['dataSaida'];
            $this->visao->livro = livroDAO::recuperarlivro($saida['livro']);
            $this->visao->livroID = fnEncrypt($this->visao->livro->get_idlivro());
            $this->visao->quantidadeMaxima = $saida['quantidadeSaida'];
            $this->visao->saidaID = $_GET['saidaID'];
            $this->renderizar();
        } else {
            die("Acesso indevido.");
        }
    }

    public function acaoRegistrarbaixa() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoGerenciarbaixasesaidas() {
$this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoGerenciar_baixas() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->visao->baixas = livroDAO::consultarBaixas("idBaixa,nomelivro,dataBaixa,quantidadeBaixa,saida,observacoes");
        $i = 0;
        foreach ($this->visao->baixas as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->baixas[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoRemover_baixa() {
        $this->visao->acessoMinimo = Permissao::ADMINISTRADOR;
        $this->renderizar();
    }

    public function acaoGerenciar_saidas() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->visao->saidas = livroDAO::consultarSaidas("idSaida,nomelivro,dataSaida,quantidadeSaidaOriginal,concat(PNome,' ',UNome) as `responsavel`");
        $i = 0;
        foreach ($this->visao->saidas as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->saidas[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoRemover_saida() {
        $this->visao->acessoMinimo = Permissao::ADMINISTRADOR;
        $this->renderizar();
    }

    public function acaoRelatorios() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Ferramenta::CONTROLE_LIVROS;
    }

}

?>
