<?php

require_once 'abstractDAO.php';
require_once APP_DIR . 'modelo/vo/Descritor.php';
require_once APP_DIR . 'modelo/enumeracao/TipoEventoImagens.php';
require_once APP_DIR . 'modelo/enumeracao/ImagensDescritor.php';

class imagensDAO extends abstractDAO {

    public function consultarGaleria($nomeGaleria) {
        $sql = "SELECT idGaleria FROM imagens_galeria WHERE nomeGaleria = :nomeGaleria";
        $params = array(
            ':nomeGaleria' => [$nomeGaleria, PDO::PARAM_STR]
        );
        return $this->executarSelect($sql, $params, false);
    }

    public function cadastrarGaleria($nomeGaleria) {
        $sql = "INSERT INTO imagens_galeria(nomeGaleria,qtdFotos,dataCriacao) VALUES (:nomeGaleria,0,:data)";
        $params = array(
            ':nomeGaleria' => [$nomeGaleria, PDO::PARAM_STR]
            , ':data' => [obterDataAtual(), PDO::PARAM_STR]
        );

        return $this->executarQuery($sql, $params);
    }

    public function consultarNomeDescritores() {
        $sql = "SELECT DISTINCT nome FROM `imagens_descritor` WHERE nome <> 'NIL'";
        return $this->executarSelect($sql);
    }

    public function cadastrarDescritor(Descritor $descritor, $idDescritorPai) {
        $sql = 'INSERT INTO imagens_descritor_aux_inserir(nome,pai) VALUES (:nome,:pai)';
        $params = array(
            ':nome' => [$descritor->get_nome(), PDO::PARAM_STR]
            , ':pai' => [$idDescritorPai, PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function cadastrarDescritorNivel1(Descritor $descritor) {
        return $this->cadastrarDescritor($descritor, ImagensDescritor::ID_RAIZ_NIVEL_ZERO);
    }

    public function consultarImagem($idImagem) {
        $sql = 'SELECT * FROM imagens_imagem WHERE idImagem = :idImagem';
        $params = array(
            ':idImagem' => [$idImagem, PDO::PARAM_INT]
        );
        return $this->executarSelect($sql, $params, false, 'Imagem');
    }

    public function consultarTodasAsImagens($limit = null, $acessoTotal = false) {
        return $this->pesquisarImagem('', $limit, $acessoTotal);
    }

    public function pesquisarImagem($termoBusca, $limite = "", $acessoTotal = false) {
        if ($acessoTotal) {
            $query_auxiliar = '';
        } else {
            $query_auxiliar = ' WHERE autor = :idUsuarioLogado ';
        }
        //Query do MAL!
        $sql = "SELECT"
                . ' t.idImagem,t.titulo,t.observacoes,t.dificuldade,t.cpfAutor,'
                . 't.ano,t.nomeArquivo,t.nomeArquivoMiniatura,t.nomeArquivoVetorial,'
                . 'concat(t1.rotulo,". ",t1.nome) as nomedescritor1, '
                . 'concat(t2.rotulo,". ",t2.nome) as nomedescritor2, '
                . 'concat(t3.rotulo,". ",t3.nome) as nomedescritor3, '
                . 'concat(t4.rotulo,". ",t4.nome) as nomedescritor4, '
                . 'concat(t1.rotulo, "_", t2.rotulo, "_", t3.rotulo, "_", t4.rotulo) as rotulo '
                . ' FROM (SELECT * from `imagens_imagem` WHERE (titulo RLIKE :termoBusca OR idImagem IN '
                . '( SELECT idImagem FROM imagens_imagem as a WHERE EXISTS '
                . '( SELECT idDescritor FROM imagens_descritor as b WHERE b.nome RLIKE :termoBusca AND (b.idDescritor = a.descritor1 OR b.idDescritor = a.descritor2 OR b.idDescritor = a.descritor3 OR b.idDescritor = a.descritor4)))'
                . ') ORDER BY idImagem ) as t'
                . ' JOIN `imagens_descritor` t1 ON t1.idDescritor = t.descritor1'
                . ' JOIN `imagens_descritor` t2 ON t2.idDescritor = t.descritor2'
                . ' JOIN `imagens_descritor` t3 ON t3.idDescritor = t.descritor3'
                . ' JOIN `imagens_descritor` t4 ON t4.idDescritor = t.descritor4 '
                . "$query_auxiliar"
                . $limite;

        try {
            $termoBusca = preg_replace('/,$/', '', $termoBusca);
        } catch (Exception $e) {
            
        }
        $aux = str_replace([',', ' '], "|", $termoBusca);
        $regexTermoBusca = "($aux)";
        $params = array(
            ':termoBusca' => [$regexTermoBusca, PDO::PARAM_STR]
            , ':idUsuarioLogado' => [obterUsuarioSessao()->get_idUsuario(), PDO::PARAM_INT]
        );
        return $this->executarSelect($sql, $params);
    }

    public function consultarDescritoresNivel1($colunas = "*", $condicao = null, $condicaoJuncao = null) {

        if ($condicao == null) {
            $condicao = " WHERE pai = " . ImagensDescritor::ID_RAIZ_NIVEL_ZERO;
        } else {
            $condicao = " WHERE pai = " . ImagensDescritor::ID_RAIZ_NIVEL_ZERO . " AND " . $condicao;
        }

        if ($condicaoJuncao == null) {
            $condicaoJuncao = "";
        }

        $sql = "SELECT $colunas FROM imagens_descritor $condicaoJuncao $condicao";
        return $this->executarSelect($sql);
    }

    public function consultarDescritor($colunas = "*", $condicao = null, $condicaoJuncao = null) {
        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = " WHERE " . $condicao;
        }

        if ($condicaoJuncao == null) {
            $condicaoJuncao = "";
        }

        $sql = "SELECT  $colunas  FROM imagens_descritor $condicaoJuncao $condicao";

        return $this->executarSelect($sql);
    }

    public function consultarCaminhoAteRaiz($idDescritorBase) {
        $caminho = array();

        $resultado = static::consultarDescritor('nome, pai', "idDescritor = $idDescritorBase");

        while ($resultado[0]['pai'] != null) {
            array_push($caminho, $resultado[0]['nome']);
            $aux = (int) $resultado[0]['pai'];
            $resultado = static::consultarDescritor('nome, pai', "idDescritor = $aux");
        }

        $endereco = "";
        $i = sizeof($caminho);
        for (; $i > 0; $i--) {
            $endereco .= array_pop($caminho) . " > ";
        }
        return $endereco . "'Novo descritor'";
    }

    public function consultarDescritoresFilhos($colunas = "*", $condicao = null, $condicaoJuncao = null) {
        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = " WHERE " . $condicao;
        }

        if ($condicaoJuncao == null) {
            $condicaoJuncao = "";
        }
        $sql = "SELECT $colunas FROM imagens_descritor " . $condicaoJuncao . $condicao;
        return $this->executarSelect($sql);
    }

    public function cadastrarImagem(Imagem $imagem) {
        $sql = "INSERT INTO imagens_imagem(idGaleria,titulo,observacoes,dificuldade,cpfAutor,ano,nomeArquivo,nomeArquivoMiniatura,nomeArquivoVetorial,descritor1,descritor2,descritor3,descritor4,autor) VALUES ";
        $sql .= "(:idGaleria,:titulo,:observacoes,:dificuldade,:cpfAutor,:ano,:nomeArquivo,:nomeArquivoMiniatura,:nomeArquivoVetorial,:des1,:des2,:des3,:des4,:autor)";
        $params = array(
            ':idGaleria' => [$imagem->get_idGaleria(), PDO::PARAM_INT]
            , ':titulo' => [$imagem->get_titulo(), PDO::PARAM_STR]
            , ':observacoes' => [$imagem->get_observacoes(), PDO::PARAM_STR]
            , ':dificuldade' => [$imagem->get_dificuldade(), PDO::PARAM_STR]
            , ':cpfAutor' => [$imagem->get_cpfAutor(), PDO::PARAM_STR]
            , ':ano' => [$imagem->get_ano(), PDO::PARAM_STR]
            , ':nomeArquivo' => [$imagem->get_nomeArquivo(), PDO::PARAM_STR]
            , ':nomeArquivoMiniatura' => [$imagem->get_nomeArquivoMiniatura(), PDO::PARAM_STR]
            , ':nomeArquivoVetorial' => [$imagem->get_nomeArquivoVetorial(), PDO::PARAM_STR]
            , ':des1' => [$imagem->get_descritor1(), PDO::PARAM_INT]
            , ':des2' => [$imagem->get_descritor2(), PDO::PARAM_INT]
            , ':des3' => [$imagem->get_descritor3(), PDO::PARAM_INT]
            , ':des4' => [$imagem->get_descritor4(), PDO::PARAM_INT]
            , ':autor' => [$imagem->get_autor(), PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function atualizarDescritor($idDescritor, Descritor $novosDados) {

        $idDescritor = (int) $idDescritor;
        $dadosAntigos = $this->recuperarDescritor($idDescritor);

        $nome = $novosDados->get_nomeCategoria();
        if ($nome == null) {
            $nome = $dadosAntigos->get_nomeCategoria();
        }


        $sql = "UPDATE imagens_descritor SET nomeCategoria = :nome WHERE idDescritor = :idDescritor";
        $params = array(
            ':nome' => [$nome, PDO::PARAM_STR],
            ':idDescritor' => [$idDescritor, PDO::PARAM_INT]
        );

        return $this->executarQuery($sql, $params);
    }

    public function recuperarDescritor($idDescritor) {

        $sql = "SELECT * from imagens_descritor WHERE idDescritor = :idDescritor";
        $params = array(
            ':idDescritor' => [$idDescritor, PDO::PARAM_INT]
        );
        return $this->executarSelect($sql, $params, false, 'Descritor');
    }

}

?>