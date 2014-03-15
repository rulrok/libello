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

    public function consultarDescritor($colunas = "*", $condicao = null, $condicaoJuncao = null, $params = null) {
        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = " WHERE " . $condicao;
        }

        if ($condicaoJuncao == null) {
            $condicaoJuncao = "";
        }

        $sql = "SELECT  $colunas  FROM imagens_descritor $condicaoJuncao $condicao";

        return $this->executarSelect($sql,$params);
    }

    public function consultarDescritoresCompletos($idDescritorExcluir = null) {
        try {
            $this->iniciarTransacao();
            $sql = 'CREATE TEMPORARY TABLE ids_aux ( id INT NOT NULL UNIQUE, pai INT NOT NULL) ENGINE = InnoDB';
            $this->executarQuery($sql);
            $sql = 'CREATE TEMPORARY TABLE ids_aux2 ( id INT NOT NULL UNIQUE, pai INT NOT NULL) ENGINE = InnoDB';
            $this->executarQuery($sql);
            $sql = 'CREATE TEMPORARY TABLE ids(id INT NOT NULL UNIQUE, pai INT NOT NULL) ENGINE = InnoDB';
            $this->executarQuery($sql);
            if ($idDescritorExcluir !== null) {
                $param = array(
                    ':idDescritorExcluir' => [$idDescritorExcluir, PDO::PARAM_INT]
                );
                //Inicia a seleção a partir dos nós de nível 1
                $sql = 'INSERT INTO ids_aux(id) SELECT idDescritor FROM imagens_descritor WHERE nivel = 1 AND idDescritor <> :idDescritorExcluir';
                $this->executarQuery($sql, $param);
                //Seleciona os filhos de nível 2 que os pais foram selecionados
                $sql = 'INSERT INTO ids_aux2(id) SELECT idDescritor FROM imagens_descritor WHERE pai IN (SELECT id FROM ids_aux) AND idDescritor <> :idDescritorExcluir';
                $this->executarQuery($sql, $param);
                ;
                //Limpa tabela temporária
                $sql = 'DELETE QUICK FROM ids_aux';
                $this->executarQuery($sql);
                //Seleciona os filhos de nível 3 que os pois foram selecionados
                $sql = 'INSERT INTO ids_aux(id) SELECT idDescritor FROM imagens_descritor WHERE pai IN (SELECT id FROM ids_aux2) AND idDescritor <> :idDescritorExcluir';
                $this->executarQuery($sql, $param);
                $sql = 'DELETE QUICK FROM ids_aux2';
                $this->executarQuery($sql);
                $sql = 'INSERT INTO ids_aux2(id) SELECT idDescritor FROM imagens_descritor WHERE pai IN (SELECT id FROM ids_aux) AND idDescritor <> :idDescritorExcluir';
                $this->executarQuery($sql, $param);
                //----//
                //Seleciona as folhas que devem pertencer à árvore
                $sql = 'INSERT INTO ids(id,pai) SELECT idDescritor,pai FROM imagens_descritor WHERE idDescritor IN (SELECT id FROM ids_aux2)';
                $this->executarQuery($sql);
                //Seleciona os pais de nível 3
                $sql = 'DELETE QUICK FROM ids_aux';
                $this->executarQuery($sql);
                $sql = 'INSERT INTO ids_aux(id,pai) SELECT idDescritor,pai FROM imagens_descritor WHERE idDescritor IN (SELECT pai FROM ids)';
                $this->executarQuery($sql);
                $sql = 'INSERT INTO ids SELECT * FROM ids_aux';
                $this->executarQuery($sql);
                //Seleciona os pais de nível 2
                $sql = 'DELETE QUICK FROM ids_aux2';
                $this->executarQuery($sql);
                $sql = 'INSERT INTO ids_aux2(id,pai) SELECT idDescritor,pai FROM imagens_descritor WHERE idDescritor IN (SELECT pai FROM ids_aux)';
                $this->executarQuery($sql);
                $sql = 'INSERT INTO ids(id,pai) SELECT * FROM ids_aux2';
                $this->executarQuery($sql);
                //Seleciona os pais de nível 1
                $sql = 'DELETE QUICK FROM ids_aux';
                $this->executarQuery($sql);
                $sql = 'INSERT INTO ids_aux(id,pai) SELECT idDescritor,pai FROM imagens_descritor WHERE idDescritor IN (SELECT pai FROM ids_aux2)';
                $this->executarQuery($sql);
                $sql = 'INSERT INTO ids(id,pai) SELECT * FROM ids_aux';
                $this->executarQuery($sql);
            } else {
                //Seleciona os filhos propriamente ditos
                $sql = "INSERT INTO ids(id) SELECT DISTINCT idDescritor FROM imagens_descritor WHERE nivel = 4";
                $this->executarQuery($sql);
                //Para encontrar os pais dos descritores nivel 4
                $sql = "INSERT INTO ids_aux(id) SELECT DISTINCT pai FROM imagens_descritor WHERE nivel = 4";
                $this->executarQuery($sql);
                //Seleciona os pais nivel 3
                $sql = 'INSERT INTO ids(id) SELECT DISTINCT idDescritor FROM imagens_descritor WHERE idDescritor IN (SELECT id FROM ids_aux)';
                $this->executarQuery($sql);
                //Para encontrar os pais dos descritores nivel 3
                $sql = 'INSERT INTO ids_aux2(id) SELECT DISTINCT pai FROM imagens_descritor WHERE idDescritor IN (SELECT id FROM ids_aux)';
                $this->executarQuery($sql);
                //Seleciona os pais nivel 2
                $sql = 'INSERT INTO ids(id) SELECT DISTINCT idDescritor FROM imagens_descritor WHERE idDescritor IN (SELECT id FROM ids_aux2)';
                $this->executarQuery($sql);
                $sql = 'DELETE QUICK FROM ids_aux;';
                $this->executarQuery($sql);
                //Para encontrar os pais dos descritores nivel 2
                $sql = 'INSERT INTO ids_aux(id) SELECT DISTINCT pai FROM imagens_descritor WHERE idDescritor IN (SELECT id FROM ids_aux2)';
                $this->executarQuery($sql);
                //Seleciona os pais nivel 1
                $sql = 'INSERT INTO ids(id) SELECT DISTINCT idDescritor FROM imagens_descritor WHERE idDescritor IN (SELECT id FROM ids_aux)';
                $this->executarQuery($sql);
            }
            $sql = 'SELECT * FROM imagens_descritor WHERE idDescritor IN (SELECT id FROM ids)';
            $resultado = $this->executarSelect($sql);
            $sql = 'DROP TEMPORARY TABLE IF EXISTS ids, ids_aux, ids_aux2';
            $this->executarQuery($sql);
            $this->encerrarTransacao();
        } catch (Exception $e) {
            $resultado = [];
            $this->rollback();
        }
        return $resultado;
    }

    public function consultarCaminhoAteRaiz($idDescritorBase) {
        $caminho = array();

        $resultado = $this->consultarDescritor('*', "idDescritor = $idDescritorBase");

        while ($resultado[0]['pai'] != null) {
            array_push($caminho, $resultado[0]);
            $aux = (int) $resultado[0]['pai'];
            $resultado = $this->consultarDescritor('*', "idDescritor = $aux");
        }

        return array_reverse($caminho);
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


        $sql = "UPDATE imagens_descritor SET nome = :nome WHERE idDescritor = :idDescritor";
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

    public function renomearDescritor($idDescritor, $novoNome) {
        $sql = "UPDATE imagens_descritor SET nome = :nome WHERE idDescritor = :idDescritor";
        $params = array(
            ':nome' => [$novoNome, PDO::PARAM_STR]
            , ':idDescritor' => [$idDescritor, PDO::PARAM_INT]
        );

        return $this->executarQuery($sql, $params);
    }

    public function moverDescritor($idDescritor, $novoPai, $antigoPai) {
        try {
            $this->iniciarTransacao();

//            $sequanciaAntigaIds = array();
//            $descAtual = $idDescritor;
//            $ret = -1;
//            while ($ret != ImagensDescritor::ID_RAIZ_NIVEL_ZERO) {
//                $sqlAux = "SELECT pai FROM imagens_descritor WHERE idDescritor = :idDescritor LIMIT 1";
//                $paramsAux = array(
//                    ':idDescritor' => [$descAtual, PDO::PARAM_INT]
//                );
//                $ret = $this->executarSelect($sqlAux, $paramsAux, FALSE);
//                $sequanciaAntigaIds[] = $ret;
//                $descAtual = $ret;
//            }
//            array_pop($sequanciaAntigaIds);
            $sequanciaNovaIds = array($novoPai);
            $descAtual = $novoPai;
            $ret = -1;
            while ($ret != ImagensDescritor::ID_RAIZ_NIVEL_ZERO) {
                $sqlAux = "SELECT pai FROM imagens_descritor WHERE idDescritor = :idDescritor LIMIT 1";
                $paramsAux = array(
                    ':idDescritor' => [$descAtual, PDO::PARAM_INT]
                );
                $ret = $this->executarSelect($sqlAux, $paramsAux, FALSE);
                $sequanciaNovaIds[] = $ret;
                $descAtual = $ret;
            }
            array_pop($sequanciaNovaIds); //Retira o '0' do vetor


            switch (sizeof($sequanciaNovaIds)) {
                case 3:
                    $sqlAtualizar = "UPDATE imagens_imagem SET descritor1 = :desc1, descritor2 = :desc2, descritor3 = :desc3 WHERE descritor4 = :desc4";
                    $paramsAtualizar = array(
                        ':desc1' => [$sequanciaNovaIds[2], PDO::PARAM_INT]
                        , ':desc2' => [$sequanciaNovaIds[1], PDO::PARAM_INT]
                        , ':desc3' => [$sequanciaNovaIds[0], PDO::PARAM_INT]
                        , ':desc4' => [$idDescritor, PDO::PARAM_INT]
                    );
                    break;
                case 2:
                    $sqlAtualizar = "UPDATE imagens_imagem SET descritor1 = :desc1, descritor2 = :desc2  WHERE descritor3 = :desc3";
                    $paramsAtualizar = array(
                        ':desc1' => [$sequanciaNovaIds[1], PDO::PARAM_INT]
                        , ':desc2' => [$sequanciaNovaIds[0], PDO::PARAM_INT]
                        , ':desc3' => [$idDescritor, PDO::PARAM_INT]
                    );
                    break;
                case 1:
                    $sqlAtualizar = "UPDATE imagens_imagem SET descritor1 = :desc1 WHERE descritor2 = :desc2";
                    $paramsAtualizar = array(
                        ':desc1' => [$sequanciaNovaIds[0], PDO::PARAM_INT]
                        , ':desc2' => [$idDescritor, PDO::PARAM_INT]
                    );
                    break;
                default:
                    throw new Exception("Erro ao processar descritores");
            }

            if (!$this->executarQuery($sqlAtualizar, $paramsAtualizar)) {
                throw new Exception("Falha ao atualizar descritores");
            }

            //------------------------------------------------------------------
            //  Atualizar informações sobre rotulo
            //------------------------------------------------------------------

            $sqlRotulo = "SELECT IFNULL ( (SELECT rotulo FROM imagens_descritor WHERE pai = :novoPai ORDER BY rotulo DESC LIMIT 1) ,0)";
            $paramsRotulo = array(
                ':novoPai' => [$novoPai, PDO::PARAM_INT]
            );
            $maiorRotuloNovoPai = $this->executarSelect($sqlRotulo, $paramsRotulo, false);
            if (is_bool($maiorRotuloNovoPai) && !$maiorRotuloNovoPai || is_null($maiorRotuloNovoPai)) {
                throw new Exception("Erro");
            }

            //------------------------------------------------------------------
            //  Mover descritor
            //------------------------------------------------------------------
            $sql = "UPDATE imagens_descritor SET pai = :novoPai,rotulo = :novoRotulo WHERE idDescritor = :idDescritor AND pai = :antigoPai";
            $params = array(
                ':novoPai' => [$novoPai, PDO::PARAM_INT]
                , ':antigoPai' => [$antigoPai, PDO::PARAM_INT]
                , ':idDescritor' => [$idDescritor, PDO::PARAM_INT]
                , ':novoRotulo' => [(int) $maiorRotuloNovoPai + 1, PDO::PARAM_INT]
            );

            if (!$this->executarQuery($sql, $params)) {
                throw new Exception("Falha ao mover descritor");
            }

            //------------------------------------------------------------------
            //  Atualizar informações sobre qtdFilhos
            //------------------------------------------------------------------

            $sql2 = "UPDATE imagens_descritor SET qtdFilhos = qtdFilhos - 1 WHERE idDescritor = :antigoPai";
            $params2 = array(
                ':antigoPai' => [$antigoPai, PDO::PARAM_INT]
            );
            if (!$this->executarQuery($sql2, $params2)) {
                throw new Exception("Falha ao atualizar informações");
            }

            $sql3 = "UPDATE imagens_descritor SET qtdFilhos = qtdFilhos + 1 WHERE idDescritor = :novoPai";
            $params3 = array(
                ':novoPai' => [$novoPai, PDO::PARAM_INT]
            );
            if (!$this->executarQuery($sql3, $params3)) {
                throw new Exception("Falha ao atualizar informações");
            }

            $this->encerrarTransacao();
            return true;
        } catch (Exception $e) {
            $this->rollback();
            return false;
        }
    }

    public function arvoreDescritores($completaApenas = false, $idDescritorExcluir = null) {
        $arvore[] = ['id' => fnEncrypt(ImagensDescritor::ID_RAIZ_NIVEL_ZERO), 'parent' => '#', 'text' => 'Descritores', 'nivel' => '0', 'rotulo' => '0', 'state' => ['opened' => true, 'selected' => true]];
        if (!$completaApenas) {
            $descritores = $this->consultarDescritor('idDescritor, nome, pai, nivel, rotulo', 'pai IS NOT NULL');
        } else {
            $descritores = $this->consultarDescritoresCompletos($idDescritorExcluir);
        }
        foreach ($descritores as $desc) {
            $arvore[] = ['id' => fnEncrypt($desc['idDescritor']), 'parent' => (fnEncrypt($desc['pai'])), 'text' => $desc['nome'], 'nivel' => $desc['nivel'], 'rotulo' => $desc['rotulo']];
        }
        return $arvore;
    }

    private function montarRecursivamente($idPai) {
        $filhos = $this->consultarDescritor('idDescritor,nome,qtdFilhos,nivel,rotulo', "pai = $idPai");
        $array = array();
        foreach ($filhos as $descritor) {
            if ($descritor['qtdFilhos'] == '0') {
                $array[] = array('id' => fnEncrypt($descritor['idDescritor']), 'text' => $descritor['nome'], 'nivel' => $descritor['nivel'], 'rotulo' => $descritor['rotulo']);
            } else {
                $array[] = array('id' => fnEncrypt($descritor['idDescritor']), 'text' => $descritor['nome'], 'nivel' => $descritor['nivel'], 'rotulo' => $descritor['rotulo'], 'children' => $this->montarRecursivamente($descritor['idDescritor']));
            }
        }
        return $array;
    }

}
