<?php

require __DIR__.'/../../../biblioteca/bancoDeDados/PDOconnectionFactory.php';


abstract class abstractDAO {

    public static $conexao;

    public function __construct() {
        self::$conexao = PDOconnectionFactory::getConection();
    }
    
    abstract function atualizar($valueObject, $condicao = null);
    
    abstract function consultar($colunas = null, $condicao = null);

    abstract function inserir($valueObject);
    
    abstract function remover($valueObject);
}

?>
