<?php

require_once BIBLIOTECA_DIR . 'configuracoes.php';
require_once BIBLIOTECA_DIR . 'bancoDeDados/PDOconnectionFactory.php';

/**
 * Centraliza as requisições para conexão com o banco de dados.
 */
abstract class abstractDAO {

    /**
     *
     * @var \PDO 
     */
    private $conexao = null;

    /**
     * 
     * @return \PDO
     */
    public function getConexao() {
        if ($this->conexao === null) {
            $this->conexao = PDOconnectionFactory::obterConexao();
        }
        return $this->conexao;
    }

    /**
     * Coloca a string entre aspas e trata aspas internas dela. Caso a string
     * seja igual a NULL, a própria string será retornada.
     * 
     * @param type $string
     * @return type Uma string entre aspas.
     * @deprecated since version number
     */
    public static function quote($string) {
        if ($string === "NULL") {
            return $string;
        }
        return $this->getConexao()->quote($string);
    }

    /**
     * 
     * @param string $sqlQuery
     * @param boolean $retornarTodos
     * @param array $params Parâmetros para casar com os curingas '?'
     * @return mixed PDOStatement, objeto da classe definida por $fetchClass, um array vazio caso não haja resultados ou null em caso de erros
     */
    public function executarSelect($sqlQuery, $params = null, $retornarTodos = true, $fetchClass = null) {
        try {
            $retorno = null;
            $conn = $this->getConexao();
            $stmt = $conn->prepare($sqlQuery);
            if ($params !== null && is_array($params) && !empty($params)) {
                foreach ($params as $campo => $opcoes) {
                    $stmt->bindValue($campo, $opcoes[0], (int) $opcoes[1]);
                }
            }
            if ($fetchClass !== null) {
                $stmt->setFetchMode(\PDO::FETCH_CLASS, $fetchClass);
            }
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                $retorno = array();
            }
            if ($retornarTodos) {
                $retorno = $stmt->fetchAll();
            } else {
                if ($fetchClass === null) {
                    $retorno = $stmt->fetch()[0];
                } else {
                    $r = $stmt->fetchObject($fetchClass);
//                    print_r($r);
                    $retorno = $r;
                }
            }
            return $retorno;
        } catch (Exception $e) {
            print_r($e);
            return null;
        }
    }

    /**
     * 
     * @param string $sql Query para ser executada, que pode ser qualquer comando SQL válido
     * @param array $params Array com os parâmetros para casar com as variáveis no formato :nomeVariável
     * @return boolean Retorna verdadeiro caso a query tenha side executada com sucesso, ou falso caso contrário
     */
    public function executarQuery($sql, $params = null, $forcarRetorno = false) {
        try {
            $conn = $this->getConexao();
            $stmt = $conn->prepare($sql);
            if ($params !== null && is_array($params)) {
                foreach ($params as $campo => $opcoes) {
                    $stmt->bindValue($campo, $opcoes[0], (int) $opcoes[1]);
                }
            }
            $stmt->execute();
            if (!$forcarRetorno) {
                return true;
            } else {
                return $stmt->rowCount();
            }
        } catch (Exception $e) {
            //TODO Armazenar exceção para depuração do sistema
            print_r($e);
            return false;
        }
    }

    public function obterUltimoIdInserido() {
//        $sql = "SELECT LAST_INSERT_ID()";
//        return $this->executarSelect($sql);
        return $this->getConexao()->lastInsertId();
    }

    public function iniciarTransacao() {
        $this->getConexao()->beginTransaction();
    }

    public function encerrarTransacao() {
        $this->getConexao()->commit();
    }

    public function rollback() {
        $this->getConexao()->rollBack();
    }

    public function transacaoEstaAberta() {
        return $this->getConexao()->inTransaction();
    }

    /*
      abstract function atualizar($valueObject, $condicao = null);

      abstract function consultar($colunas = null, $condicao = null);

      abstract function inserir($valueObject);

      abstract function remover($valueObject);
     */
}

?>
