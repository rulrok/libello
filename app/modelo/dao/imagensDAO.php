<?php

require_once 'abstractDAO.php';
require_once APP_DIR . 'modelo/vo/Descritor.php';
require_once APP_DIR . 'modelo/enumeracao/TipoEventoImagens.php';
require_once APP_DIR . 'modelo/enumeracao/ImagensDescritor.php';

class imagensDAO extends abstractDAO {

    // <editor-fold defaultstate="collapsed" desc="Métodos associados a imagens">
    /**
     * Retorna todas as informações de uma imagem
     * 
     * @param int $idImagem
     * @return Imagem
     */
    public function consultarImagem($idImagem) {
        $sql = 'SELECT * FROM imagem WHERE idImagem = :idImagem';
        $params = array(
            ':idImagem' => [$idImagem, PDO::PARAM_INT]
        );
        return $this->executarSelect($sql, $params, false, 'Imagem');
    }

    public function consultarTodasAsImagens($limit = null, $acessoTotal = false) {
        return $this->pesquisarImagem('', $limit, $acessoTotal);
    }

    /**
     * Realiza uma busca nas imagens do banco de dados por
     * @param string $termoBusca Uma string no formato "termo1,termo2,termo3,...,termo-n"
     * @param string $limite Trecho SQL (LIMIT ...) válido
     * @param boolean $acessoTotal Indica se o resultado deve retornar todas as imagens de todos os autores, ou apenas do usuário logado atualmente
     * @return type
     */
    public function pesquisarImagem($termoBusca, $limite = "", $acessoTotal = false, $autor = null, $dataInicio = null, $dataFim = null) {

        $params = array();

        //Variável onde as queries auxiliares serão armazenadas.
        //Após isso, ele é processado para gerar uma condição WHERE válida 
        //para ser adicionado ao final da query.
        $condicoes = array();

        //Monta a query que irá filtrar os resultados baseado no autor
        if ($acessoTotal) {
            if ($autor !== null) {
                $query_auxiliar_autor = ' autor = :idAutor ';
                $params[':idAutor'] = [$autor, PDO::PARAM_INT];
            } else {
                $query_auxiliar_autor = '';
            }
        } else {
            $query_auxiliar_autor = ' autor = :idUsuarioLogado ';
            $params[':idUsuarioLogado'] = [obterUsuarioSessao()->get_idUsuario(), PDO::PARAM_INT];
        }

        if (!empty($query_auxiliar_autor)) {
            $condicoes[] = $query_auxiliar_autor;
        }

        //Monta a query que irá filtrar os resultados com base na data de registro da imagem no banco
        if ($dataInicio !== null) {
            if ($dataFim !== null) {
                $query_auxiliar_data = ' (dataCadastro BETWEEN :inicio AND :fim) ';
                $params[':fim'] = [$dataFim, PDO::PARAM_INT];
            } else {
                $query_auxiliar_data = ' dataCadastro >= :inicio ';
            }
            $params[':inicio'] = [$dataInicio, PDO::PARAM_INT];
        } elseif ($dataFim !== null) {
            $query_auxiliar_data = ' dataCadastro <= :fim ';
            $params[':fim'] = [$dataFim, PDO::PARAM_INT];
        } else {
            $query_auxiliar_data = '';
        }

        if (!empty($query_auxiliar_data)) {
            $condicoes[] = $query_auxiliar_data;
        }


        //Processamento das condições
        $query_where_aux = "";
        foreach ($condicoes as $condicao) {
            $query_where_aux .= $condicao . " AND ";
        }

        if (!empty($query_where_aux)) {
            $query_where = " WHERE " . preg_replace("/AND +$/", "", $query_where_aux);
        } else {
            $query_where = "";
        }


        //Query do MAL!
        $sql = "SELECT"
                . ' t.idImagem,t.titulo,t.observacoes,t.dificuldade,concat(PNome," ",UNome) as autor, '
                . 't.ano,t.diretorio,t.diretorioMiniatura,t.nomeArquivo,t.nomeArquivoMiniatura,t.nomeArquivoVetorial, '
                . 't.dataCadastro, '
//                . 'concat(t1.rotulo," ",t1.nome) as nomedescritor1, '
//                . 'concat(t2.rotulo," ",t2.nome) as nomedescritor2, '
//                . 'concat(t3.rotulo," ",t3.nome) as nomedescritor3, '
//                . 'concat(t4.rotulo," ",t4.nome) as nomedescritor4 '
                . 't1.nome as nomedescritor1, '
                . 't2.nome as nomedescritor2, '
                . 't3.nome as nomedescritor3, '
                . 't4.nome as nomedescritor4 '
//                . 'concat(t1.nome, ", ", t2.nome, ", ", t3.nome, ", ", t4.nome) as descritores '
                . ' FROM (SELECT * from `imagem` WHERE (titulo RLIKE :termoBusca OR idImagem IN '
                . '( SELECT idImagem FROM imagem as a WHERE EXISTS '
                . '( SELECT idDescritor FROM imagem_descritor as b WHERE b.nome RLIKE :termoBusca AND (b.idDescritor = a.descritor1 OR b.idDescritor = a.descritor2 OR b.idDescritor = a.descritor3 OR b.idDescritor = a.descritor4)))'
                . ') ORDER BY idImagem ) as t'
                . ' JOIN `imagem_descritor` t1 ON t1.idDescritor = t.descritor1'
                . ' JOIN `imagem_descritor` t2 ON t2.idDescritor = t.descritor2'
                . ' JOIN `imagem_descritor` t3 ON t3.idDescritor = t.descritor3'
                . ' JOIN `imagem_descritor` t4 ON t4.idDescritor = t.descritor4 '
                . ' JOIN `usuario` us ON autor = us.idUsuario '
                . $query_where
                . $limite;


        $termoBusca = ltrim(rtrim(rtrim($termoBusca, ','))); //preg_replace('/,$/', '', $termoBusca);
        //Elimina possíveis vírgulas no início e fim
        $aux = str_replace(['/^,+/', '/,+$/'], '', $termoBusca);
        $aux = str_replace([','], "|", $termoBusca);

        if (!empty($aux)) {
            $regexTermoBusca = "($aux)";
        } else {
            $regexTermoBusca = ".";
        }
        $params[':termoBusca'] = [$regexTermoBusca, PDO::PARAM_STR];

        return $this->executarSelect($sql, $params);
    }

    public function cadastrarImagem(Imagem $imagem) {
        $sql = "INSERT INTO imagem(idGaleria,titulo,observacoes,dificuldade,cpfAutor,ano,nomeArquivo,diretorio,diretorioMiniatura,nomeArquivoMiniatura,nomeArquivoVetorial,descritor1,descritor2,descritor3,descritor4,autor,dataCadastro) VALUES ";
        $sql .= "(:idGaleria,:titulo,:observacoes,:dificuldade,:cpfAutor,:ano,:nomeArquivo,:diretorio,:diretorioMiniatura,:nomeArquivoMiniatura,:nomeArquivoVetorial,:des1,:des2,:des3,:des4,:autor,:dataCadastro)";
        $params = array(
            ':idGaleria' => [$imagem->get_idGaleria(), PDO::PARAM_INT]
            , ':titulo' => [$imagem->get_titulo(), PDO::PARAM_STR]
            , ':observacoes' => [$imagem->get_observacoes(), PDO::PARAM_STR]
            , ':dificuldade' => [$imagem->get_dificuldade(), PDO::PARAM_STR]
            , ':cpfAutor' => [$imagem->get_cpfAutor(), PDO::PARAM_STR]
            , ':ano' => [$imagem->get_ano(), PDO::PARAM_STR]
            , ':diretorio' => [$imagem->get_diretorio()]
            , ':diretorioMiniatura' => [$imagem->get_diretorioMiniatura()]
            , ':nomeArquivo' => [$imagem->get_nomeArquivo(), PDO::PARAM_STR]
            , ':nomeArquivoMiniatura' => [$imagem->get_nomeArquivoMiniatura(), PDO::PARAM_STR]
            , ':nomeArquivoVetorial' => [$imagem->get_nomeArquivoVetorial(), PDO::PARAM_STR]
            , ':des1' => [$imagem->get_descritor1(), PDO::PARAM_INT]
            , ':des2' => [$imagem->get_descritor2(), PDO::PARAM_INT]
            , ':des3' => [$imagem->get_descritor3(), PDO::PARAM_INT]
            , ':des4' => [$imagem->get_descritor4(), PDO::PARAM_INT]
            , ':autor' => [$imagem->get_autor(), PDO::PARAM_INT]
            , ':dataCadastro' => [time(), PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    /**
     * Há três situações na qual o nome do arquivo final do arquivo salvo no servidor
     * pode ficar desatualizado com as informações reais do cadastro da imagem.
     * 
     * Por exemplo, o nome do arquivo segue o seguinte formato:
     * <code>[rotuloDescritor1]-[rotuloDescritor2]-[rotuloDescritor3]-[dificuldade]-[siglaAutor][_dataCriacao(timestamp)].[extensão]</code>
     * 
     * Atualmente, é possível realizar uma dessas operações que podem tornar esse nome inconsistente
     * com os atuais descritores ou sigla do nome do autor:
     * 
     * <ol>
     * <li>Excluir um descritor</li>
     * <li>Mover um descritor na árvore de descritores</li>
     * <li>O nome de um usuário ser atualizado</li>
     * </ol>
     * 
     * <b> IMPORTANTE: </b>Essa função deve ser chamada após uma das alterações citadas
     * acimas serem realizadas para então ser feita uma varredura em todos os registros
     * das imagens passadas por parâmetro onde os arquivos serão renomeados no banco de dados
     * com base nas novas informações encontradas (pelas chaves estrangeiras) e logo em seguida
     * os arquivos das imagens, miniaturas e arquivos vetorizados também serem atualizados
     * no disco do servidor.
     * 
     * @param array $idsImagens Vetor com o ID das imagens que devem ser verificadas.
     * O formato esperado do vetor é um vetor onde cada índice há um outro vetor e
     * esse vetor possui na posição 0 o valor numérico do ID do descritor
     * 
     * <b>Ex:</n> [ [0 => id1],[0 => id2],...,[0 => id_n] ]
     */
    public function atualizarNomeArquivoImagens(array $idsImagens) {
        $antigoCaminho = getcwd();
        chdir(ROOT);
        foreach ($idsImagens as $value) {
            $id = $value[0];
            if (!is_numeric($id)) {
                continue;
            }

            $imagem = $this->consultarImagem($id);

            $diretorioGaleria = $imagem->get_diretorio();
            $diretorioMiniatura = $imagem->get_diretorioMiniatura();

            $antigoNomeArquivo = $imagem->get_nomeArquivo();
            $antigoNomeMiniatura = $imagem->get_nomeArquivoMiniatura();
            $antigoNomeArquivoVetorial = $imagem->get_nomeArquivoVetorial();

            $novoRotulo1 = $this->consultarDescritor('rotulo', 'idDescritor = :rotulo1 LIMIT 1', null, array(':rotulo1' => [$imagem->get_descritor1(), PDO::PARAM_INT]))[0]['rotulo'];
            $novoRotulo2 = $this->consultarDescritor('rotulo', 'idDescritor = :rotulo2 LIMIT 1', null, array(':rotulo2' => [$imagem->get_descritor2(), PDO::PARAM_INT]))[0]['rotulo'];
            $novoRotulo3 = $this->consultarDescritor('rotulo', 'idDescritor = :rotulo3 LIMIT 1', null, array(':rotulo3' => [$imagem->get_descritor3(), PDO::PARAM_INT]))[0]['rotulo'];
            $dificuldade = $imagem->get_dificuldade();
            $novaSigla = obterUsuarioSessao()->get_iniciais();

            $nomeFinal = $novoRotulo1 . "-" . $novoRotulo2 . "-" . $novoRotulo3 . "-" . $dificuldade . "-" . $novaSigla . "_";

            $regex = '/.*?_/'; //Importante: Deve ser utilizado o quantificador NÃO GULOSO para a expressão parar no primeiro _ (underline) do nome.
            $novoNomeArquivo = preg_replace($regex, $nomeFinal, $antigoNomeArquivo, 1);
            $novoNomeMiniatura = preg_replace($regex, $nomeFinal, $antigoNomeMiniatura, 1);
            $novoNomeArquivoVetorial = preg_replace($regex, $nomeFinal, $antigoNomeArquivoVetorial, 1);

            if (!rename($diretorioGaleria . $antigoNomeArquivo, $diretorioGaleria . $novoNomeArquivo)) {
                continue;
            }

            if (!rename($diretorioGaleria . $antigoNomeArquivoVetorial, $diretorioGaleria . $novoNomeArquivoVetorial)) {
                //Desfaz as alterações
                if (file_exists($diretorioGaleria . $novoNomeArquivo)) {
                    rename($diretorioGaleria . $novoNomeArquivo, $diretorioGaleria . $antigoNomeArquivo);
                }
                continue;
            }

            if (!rename($diretorioMiniatura . $antigoNomeMiniatura, $diretorioMiniatura . $novoNomeMiniatura)) {
                //Desfaz as alterações
                if (file_exists($diretorioGaleria . $novoNomeArquivo)) {
                    rename($diretorioGaleria . $novoNomeArquivo, $diretorioGaleria . $antigoNomeArquivo);
                }
                if (file_exists($diretorioGaleria . $novoNomeArquivoVetorial)) {
                    rename($diretorioGaleria . $novoNomeArquivoVetorial, $diretorioGaleria . $antigoNomeArquivoVetorial);
                }
                continue;
            }

            $sql = "UPDATE imagem SET nomeArquivo = :nomeArquivo, nomeArquivoMiniatura = :nomeArquivoMiniatura, nomeArquivoVetorial = :nomeArquivoVetorial WHERE idImagem = :idImagem";
            $params = array(
                ':nomeArquivo' => [$novoNomeArquivo, PDO::PARAM_STR]
                , ':nomeArquivoMiniatura' => [$novoNomeMiniatura, PDO::PARAM_STR]
                , ':nomeArquivoVetorial' => [$novoNomeArquivoVetorial, PDO::PARAM_STR]
                , ':idImagem' => [$id, PDO::PARAM_INT]
            );

            if (!$this->executarQuery($sql, $params)) {
                //Desfaz as alterações
                if (file_exists($diretorioGaleria . $novoNomeArquivo)) {
                    rename($diretorioGaleria . $novoNomeArquivo, $diretorioGaleria . $antigoNomeArquivo);
                }
                if (file_exists($diretorioGaleria . $novoNomeArquivoVetorial)) {
                    rename($diretorioGaleria . $novoNomeArquivoVetorial, $diretorioGaleria . $antigoNomeArquivoVetorial);
                }
                if (file_exists($diretorioMiniatura . $novoNomeMiniatura)) {
                    rename($diretorioMiniatura . $novoNomeMiniatura, $diretorioMiniatura . $antigoNomeMiniatura);
                }
                continue;
            }
        }
        chdir($antigoCaminho);
        return true;
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Métodos associados a galerias">
    public function consultarGaleria($nomeGaleria) {
        $sql = "SELECT idGaleria FROM imagem_galeria WHERE nomeGaleria = :nomeGaleria";
        $params = array(
            ':nomeGaleria' => [$nomeGaleria, PDO::PARAM_STR]
        );
        return $this->executarSelect($sql, $params, false);
    }

    public function cadastrarGaleria($nomeGaleria, $idAutor) {
        $sql = "INSERT INTO imagem_galeria(nomeGaleria,qtdFotos,dataCriacao,autor) VALUES (:nomeGaleria,0,:data,:autor)";
        $params = array(
            ':nomeGaleria' => [$nomeGaleria, PDO::PARAM_STR]
            , ':data' => [time(), PDO::PARAM_INT]
            , ':autor' => [$idAutor, pint]
        );

        return $this->executarQuery($sql, $params);
    }

// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Métodos associados a descritores">

    /**
     * Função para cadastrar exclusivamente descritores de nível 1 na base de dados.
     * Para descritores de demais níveis, <code>cadastrarDescritor()</code> deve ser utilizado.
     * 
     * @param Descritor $descritor
     * @return boolean TRUE em caso de sucesso, FALSE em caso de insucesso.
     */
    public function cadastrarDescritorNivel1(Descritor $descritor) {
        return $this->cadastrarDescritor($descritor, ImagensDescritor::ID_RAIZ_NIVEL_ZERO);
    }

    /**
     * 
     * @param Descritor $descritor Objeto com o nome do novo descritor configurado apenas
     * @param int $idDescritorPai
     * @return boolean TRUE em caso de sucesso, FALSE em caso de insucesso.
     */
    public function cadastrarDescritor(Descritor $descritor, $idDescritorPai) {
        $sql = 'INSERT INTO imagem_descritor_aux_inserir(nome,pai) VALUES (:nome,:pai)';
        $nomeNormalizado = normalizarNomeDescritor($descritor->get_nome());
        $params = array(
            ':nome' => [$nomeNormalizado, PDO::PARAM_STR]
            , ':pai' => [$idDescritorPai, PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    /**
     * Função que consulta exclusivamente descritores de <b>nível 1</b>.
     * Para a consulta dos demais descritores do sistema, incluíndo também <i>ou não</i> os descritores
     * de nível 1, utilize o método <b>consultarDescritor()</b>
     */
    public function consultarDescritoresNivel1($colunas = "*", $condicao = null, $condicaoJuncao = null) {

        if ($condicao == null) {
            $condicao = " WHERE pai = " . ImagensDescritor::ID_RAIZ_NIVEL_ZERO;
        } else {
            $condicao = " WHERE pai = " . ImagensDescritor::ID_RAIZ_NIVEL_ZERO . " AND " . $condicao;
        }

        if ($condicaoJuncao == null) {
            $condicaoJuncao = "";
        }

        $sql = "SELECT $colunas FROM imagem_descritor $condicaoJuncao $condicao";
        return $this->executarSelect($sql);
    }

    /**
     * Faz uma consulta retornando todos os descritores que coincidem com as condições de busca.
     * 
     */
    public function consultarDescritor($colunas = "*", $condicao = null, $condicaoJuncao = null, $params = null) {
        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = " WHERE " . $condicao;
        }

        if ($condicaoJuncao == null) {
            $condicaoJuncao = "";
        }

        $sql = "SELECT  $colunas  FROM imagem_descritor $condicaoJuncao $condicao";

        return $this->executarSelect($sql, $params);
    }

    /**
     * Função que retorna a árvore de descritores contendo apenas os ramos que são completos,
     * ou seja, que possuem as folhas no nível 4. Opcionalmente pode-se indicar um descritor
     * para não ser incluído nessa árvore, e isso poderá causar a poda de todo um ramo da 
     * árvore.
     * 
     * @param int $idDescritorExcluir
     * @return array Um array no formato esperado para o componente jsTree (jQuery)
     */
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
                $sql = 'INSERT INTO ids_aux(id) SELECT idDescritor FROM imagem_descritor WHERE nivel = 1 AND idDescritor <> :idDescritorExcluir';
                $this->executarQuery($sql, $param);
                //Seleciona os filhos de nível 2 que os pais foram selecionados
                $sql = 'INSERT INTO ids_aux2(id) SELECT idDescritor FROM imagem_descritor WHERE pai IN (SELECT id FROM ids_aux) AND idDescritor <> :idDescritorExcluir';
                $this->executarQuery($sql, $param);
                ;
                //Limpa tabela temporária
                $sql = 'DELETE QUICK FROM ids_aux';
                $this->executarQuery($sql);
                //Seleciona os filhos de nível 3 que os pois foram selecionados
                $sql = 'INSERT INTO ids_aux(id) SELECT idDescritor FROM imagem_descritor WHERE pai IN (SELECT id FROM ids_aux2) AND idDescritor <> :idDescritorExcluir';
                $this->executarQuery($sql, $param);
                $sql = 'DELETE QUICK FROM ids_aux2';
                $this->executarQuery($sql);
                $sql = 'INSERT INTO ids_aux2(id) SELECT idDescritor FROM imagem_descritor WHERE pai IN (SELECT id FROM ids_aux) AND idDescritor <> :idDescritorExcluir';
                $this->executarQuery($sql, $param);
                //----//
                //Seleciona as folhas que devem pertencer à árvore
                $sql = 'INSERT INTO ids(id,pai) SELECT idDescritor,pai FROM imagem_descritor WHERE idDescritor IN (SELECT id FROM ids_aux2)';
                $this->executarQuery($sql);
                //Seleciona os pais de nível 3
                $sql = 'DELETE QUICK FROM ids_aux';
                $this->executarQuery($sql);
                $sql = 'INSERT INTO ids_aux(id,pai) SELECT idDescritor,pai FROM imagem_descritor WHERE idDescritor IN (SELECT pai FROM ids)';
                $this->executarQuery($sql);
                $sql = 'INSERT INTO ids SELECT * FROM ids_aux';
                $this->executarQuery($sql);
                //Seleciona os pais de nível 2
                $sql = 'DELETE QUICK FROM ids_aux2';
                $this->executarQuery($sql);
                $sql = 'INSERT INTO ids_aux2(id,pai) SELECT idDescritor,pai FROM imagem_descritor WHERE idDescritor IN (SELECT pai FROM ids_aux)';
                $this->executarQuery($sql);
                $sql = 'INSERT INTO ids(id,pai) SELECT * FROM ids_aux2';
                $this->executarQuery($sql);
                //Seleciona os pais de nível 1
                $sql = 'DELETE QUICK FROM ids_aux';
                $this->executarQuery($sql);
                $sql = 'INSERT INTO ids_aux(id,pai) SELECT idDescritor,pai FROM imagem_descritor WHERE idDescritor IN (SELECT pai FROM ids_aux2)';
                $this->executarQuery($sql);
                $sql = 'INSERT INTO ids(id,pai) SELECT * FROM ids_aux';
                $this->executarQuery($sql);
            } else {
                //Seleciona os filhos propriamente ditos
                $sql = "INSERT INTO ids(id) SELECT DISTINCT idDescritor FROM imagem_descritor WHERE nivel = 4";
                $this->executarQuery($sql);
                //Para encontrar os pais dos descritores nivel 4
                $sql = "INSERT INTO ids_aux(id) SELECT DISTINCT pai FROM imagem_descritor WHERE nivel = 4";
                $this->executarQuery($sql);
                //Seleciona os pais nivel 3
                $sql = 'INSERT INTO ids(id) SELECT DISTINCT idDescritor FROM imagem_descritor WHERE idDescritor IN (SELECT id FROM ids_aux)';
                $this->executarQuery($sql);
                //Para encontrar os pais dos descritores nivel 3
                $sql = 'INSERT INTO ids_aux2(id) SELECT DISTINCT pai FROM imagem_descritor WHERE idDescritor IN (SELECT id FROM ids_aux)';
                $this->executarQuery($sql);
                //Seleciona os pais nivel 2
                $sql = 'INSERT INTO ids(id) SELECT DISTINCT idDescritor FROM imagem_descritor WHERE idDescritor IN (SELECT id FROM ids_aux2)';
                $this->executarQuery($sql);
                $sql = 'DELETE QUICK FROM ids_aux;';
                $this->executarQuery($sql);
                //Para encontrar os pais dos descritores nivel 2
                $sql = 'INSERT INTO ids_aux(id) SELECT DISTINCT pai FROM imagem_descritor WHERE idDescritor IN (SELECT id FROM ids_aux2)';
                $this->executarQuery($sql);
                //Seleciona os pais nivel 1
                $sql = 'INSERT INTO ids(id) SELECT DISTINCT idDescritor FROM imagem_descritor WHERE idDescritor IN (SELECT id FROM ids_aux)';
                $this->executarQuery($sql);
            }
            $sql = 'SELECT * FROM imagem_descritor WHERE idDescritor IN (SELECT id FROM ids)';
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

    /**
     * 
     * @param type $idDescritorBase
     * @return array
     */
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

    /**
     * Retorna todos os descritores filhos do descritor base informado pelo seu ID.
     * @param int $idPai
     * @return mixed
     */
    public function consultarDescritoresFilhos($idPai) {


        $sql = "SELECT * FROM imagem_descritor WHERE pai = :pai";
        $params = array(
            ':pai' => [$idPai, PDO::PARAM_INT]
        );
        return $this->executarSelect($sql, $params);
    }

    public function renomearDescritor($idDescritor, $novoNome) {
        $sql = "UPDATE imagem_descritor SET nome = :nome WHERE idDescritor = :idDescritor";
        $nomeNormalizado = normalizarNomeDescritor($novoNome);
        $params = array(
            ':nome' => [$nomeNormalizado, PDO::PARAM_STR]
            , ':idDescritor' => [$idDescritor, PDO::PARAM_INT]
        );

        return $this->executarQuery($sql, $params);
    }

    /**
     * Move um descritor para um novo pai, não alterando seu nível na árvore, e atualizando
     * todas as imagens que o possui para refletir as novas condições da árvore
     * de descritores
     * 
     * @param int $idDescritor
     * @param int $idNovoPai
     * @param int $idAntigoPai
     * @return boolean
     * @throws Exception
     */
    public function moverDescritor($idDescritor, $idNovoPai, $idAntigoPai) {
        //TODO $idAntigoPai poderá ser eliminado, pois ele é deduzível a partir de $idDescritor
        //Mas talvez possa ser mantido por questão de redundância de verificação
        try {
            $this->iniciarTransacao();

            $sequanciaNovaIds = array($idNovoPai);
            $descAtual = $idNovoPai;
            $ret = -1;
            while ($ret != ImagensDescritor::ID_RAIZ_NIVEL_ZERO) {
                $sqlAux = "SELECT pai FROM imagem_descritor WHERE idDescritor = :idDescritor LIMIT 1";
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
                    $sqlAtualizar = "UPDATE imagem SET descritor1 = :desc1, descritor2 = :desc2, descritor3 = :desc3 WHERE descritor4 = :desc4";
                    $paramsAtualizar = array(
                        ':desc1' => [$sequanciaNovaIds[2], PDO::PARAM_INT]
                        , ':desc2' => [$sequanciaNovaIds[1], PDO::PARAM_INT]
                        , ':desc3' => [$sequanciaNovaIds[0], PDO::PARAM_INT]
                        , ':desc4' => [$idDescritor, PDO::PARAM_INT]
                    );
                    break;
                case 2:
                    $sqlAtualizar = "UPDATE imagem SET descritor1 = :desc1, descritor2 = :desc2  WHERE descritor3 = :desc3";
                    $paramsAtualizar = array(
                        ':desc1' => [$sequanciaNovaIds[1], PDO::PARAM_INT]
                        , ':desc2' => [$sequanciaNovaIds[0], PDO::PARAM_INT]
                        , ':desc3' => [$idDescritor, PDO::PARAM_INT]
                    );
                    break;
                case 1:
                    $sqlAtualizar = "UPDATE imagem SET descritor1 = :desc1 WHERE descritor2 = :desc2";
                    $paramsAtualizar = array(
                        ':desc1' => [$sequanciaNovaIds[0], PDO::PARAM_INT]
                        , ':desc2' => [$idDescritor, PDO::PARAM_INT]
                    );
                    break;
                default:
                    throw new Exception("Erro ao processar descritores");
            }

            if (!$this->executarQuery($sqlAtualizar, $paramsAtualizar)) {
                //Essa exceção causa um rollback
                throw new Exception("Falha ao atualizar descritores");
            }

            //------------------------------------------------------------------
            //  Atualizar informações sobre rotulo
            //------------------------------------------------------------------

            $sqlRotulo = "SELECT IFNULL ( (SELECT rotulo FROM imagem_descritor WHERE pai = :novoPai ORDER BY rotulo DESC LIMIT 1) ,0)";
            $paramsRotulo = array(
                ':novoPai' => [$idNovoPai, PDO::PARAM_INT]
            );
            $maiorRotuloNovoPai = $this->executarSelect($sqlRotulo, $paramsRotulo, false);
            if (is_bool($maiorRotuloNovoPai) && !$maiorRotuloNovoPai || is_null($maiorRotuloNovoPai)) {
                throw new Exception("Erro");
            }

            //------------------------------------------------------------------
            //  Mover descritor
            //------------------------------------------------------------------
            $sql = "UPDATE imagem_descritor SET pai = :novoPai,rotulo = :novoRotulo WHERE idDescritor = :idDescritor AND pai = :antigoPai";
            $params = array(
                ':novoPai' => [$idNovoPai, PDO::PARAM_INT]
                , ':antigoPai' => [$idAntigoPai, PDO::PARAM_INT]
                , ':idDescritor' => [$idDescritor, PDO::PARAM_INT]
                , ':novoRotulo' => [(int) $maiorRotuloNovoPai + 1, PDO::PARAM_INT]
            );

            if (!$this->executarQuery($sql, $params)) {
                throw new Exception("Falha ao mover descritor");
            }

            //------------------------------------------------------------------
            //  Atualizar informações sobre qtdFilhos
            //------------------------------------------------------------------

            $sql2 = "UPDATE imagem_descritor SET qtdFilhos = qtdFilhos - 1 WHERE idDescritor = :antigoPai";
            $params2 = array(
                ':antigoPai' => [$idAntigoPai, PDO::PARAM_INT]
            );
            if (!$this->executarQuery($sql2, $params2)) {
                throw new Exception("Falha ao atualizar informações");
            }

            $sql3 = "UPDATE imagem_descritor SET qtdFilhos = qtdFilhos + 1 WHERE idDescritor = :novoPai";
            $params3 = array(
                ':novoPai' => [$idNovoPai, PDO::PARAM_INT]
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

    /**
     * Monta um array configurado no formato esperado pelo componente jQuery jsTree para montar uma estrutura de árvore de descritores.
     * 
     * @param boolean $completaApenas Indica se a árvore montada deve ser completa, ou seja, excluir ramos incompletos da existente árvore de descritores
     * cadastrada no banco.
     * @param int $idDescritorExcluir Descritor ao qual a partir dele, todo o seu ramo será desconsiderado da árvore <b>completa</b>, ou seja, apenas tem
     * efeito quando $completaApenas for <b>true</b>
     * @return array
     */
    public function arvoreDescritores($completaApenas = false, $idDescritorExcluir = null) {
        $arvore[] = ['id' => fnEncrypt(ImagensDescritor::ID_RAIZ_NIVEL_ZERO), 'parent' => '#', 'text' => 'Descritores', 'nivel' => '0', 'rotulo' => '0', 'state' => ['opened' => true, 'selected' => true]];
        if (!$completaApenas) {
            $descritores = $this->consultarDescritor('idDescritor, nome, pai, nivel, rotulo', 'pai IS NOT NULL');
        } else {
            $descritores = $this->consultarDescritoresCompletos($idDescritorExcluir);
        }
        foreach ($descritores as $desc) {
            $arvore[] = ['id' => fnEncrypt($desc['idDescritor']), 'parent' => (fnEncrypt($desc['pai'])), 'text' => $desc['rotulo'] . '.' . $desc['nome'], 'nivel' => $desc['nivel'], 'rotulo' => $desc['rotulo']];
        }
        return $arvore;
    }

    /**
     * Monta um vetor que pode ser usado como resposta para o componente jsTree para exibir uma árvore hierarquica 
     * dos descritores.
     * 
     * @param int $idPai Quem será a raiz da árvore
     * @return array
     * @deprecated Método recursivo que pode prejudicar o desempenho do sistema. É basicamente substituída por 'arvoreDescritores()'
     */
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

// </editor-fold>
}
