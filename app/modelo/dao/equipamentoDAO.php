<?php

require_once 'abstractDAO.php';

class equipamentoDAO extends abstractDAO {
    
    
    public static function cadastrarEquipamento(Equipamento $equipamento){
        $sql = "INSERT INTO equipamento(nomeEquipamento,quantidade,dataEntrada,numeroPatrimonio) VALUES ";
        $nome = parent::quote($equipamento->get_nomeEquipamento());
        $quantidade = $equipamento->get_quantidadde();
        $dataEntrada = parent::quote($equipamento->get_dataEntrada());
        $numeroPatrimonio = parent::quote($equipamento->get_numeroPatrimonio());
        $values = "($nome,$quantidade,$dataEntrada,$numeroPatrimonio)";
        try {
            parent::getConexao()->query($sql . $values);
        } catch (Exception $e) {
            throw new Exception("Erro");
        }
    }
}

?>
