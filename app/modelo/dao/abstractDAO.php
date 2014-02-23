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
        if ($this->conexao == null) {
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
     */
    public static function quote($string) {
        if ($string == "NULL") {
            return $string;
        }
        return $this->getConexao()->quote($string);
    }

    /**
     * 
     * @param string $sqlQuery
     * @param boolean $retornarTodos
     * @param array $params Parâmetros para casar com os curingas '?'
     * @return mixed PDOStatement, objeto da classe definida por $fetchClass ou null caso não haja resultados
     */
    public function executarSelect($sqlQuery, $params = null, $retornarTodos = true, $fetchClass = null) {
        try {
            $conn = $this->getConexao();
            $stmt = $conn->prepare($sqlQuery);
            if ($params !== null && is_array($params)) {
                foreach ($params as $campo => $opcoes) {
                    $stmt->bindValue($campo, $opcoes[0], (int) $opcoes[1]);
                }
            }
            if ($fetchClass !== null) {
                $stmt->setFetchMode(\PDO::FETCH_CLASS, $fetchClass);
            }
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                return null;
            }
            if ($retornarTodos) {
                return $stmt->fetchAll();
            } else {
                if ($fetchClass === null) {
                    return $stmt->fetch()[0];
                } else {
                    $r = $stmt->fetchObject($fetchClass);
//                    print_r($r);
                    return $r;
                }
            }
        } catch (Exception $e) {
            print_r($e);
            return null;
        }
    }

    /**
     * 
     * @param type $sql
     * @param type $params
     * @return boolean
     */
    public function executarQuery($sql, $params) {
        try {
            $conn = $this->getConexao();
            $stmt = $conn->prepare($sql);
            if ($params !== null && is_array($params)) {
                foreach ($params as $campo => $opcoes) {
                    $stmt->bindValue($campo, $opcoes[0], (int) $opcoes[1]);
                }
            }
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            //TODO Armazenar exceção para depuração do sistema
            print_r($e);
            return false;
        }
    }

    /*
      abstract function atualizar($valueObject, $condicao = null);

      abstract function consultar($colunas = null, $condicao = null);

      abstract function inserir($valueObject);

      abstract function remover($valueObject);
     */
}

?>
