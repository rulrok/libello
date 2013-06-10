<?php

require_once 'abstractDAO.php';

class poloDAO extends abstractDAO {

    public static function cadastrarPolo(Polo $polo) {
        $sql = "INSERT INTO polo(nome,cidade,estado) VALUES ";
        $nome = parent::quote($polo->get_nome());
        $cidade = parent::quote($polo->get_cidade());
        $estado = parent::quote($polo->get_estado());
        $values = "($nome,$cidade,$estado)";
        try {
            parent::getConexao()->query($sql . $values);
        } catch (Exception $e) {
            echo $e;
        }
    }

    public static function consultarPolo(Polo $polo) {
        $sql = "SELECT count(idPolo) FROM polo WHERE ";
        $nome = parent::quote($polo->get_nome());
        $cidade = parent::quote($polo->get_cidade());
        $estado = parent::quote($polo->get_estado());
        $condicao = "nome = $nome AND cidade=$cidade AND estado = $estado";
        try {
            $resultado = parent::getConexao()->query($sql . $condicao)->fetch();
        } catch (Exception $e) {
            echo $e;
        }

        if (is_array($resultado)) {
            $resultado = $resultado[0];
        }
        return $resultado;
    }

}

?>
