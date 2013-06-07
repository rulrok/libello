<?php

require_once 'abstractDAO.php';

class sistemaDAO extends abstractDAO {

    public static function registrarAccesso($idUsuario) {
        $quote = "\"";
        $sql = "INSERT INTO usuarios_logs(data,hora,idUsuario) VALUES (<data>,<hora>,<idUsuario>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        $sql = str_replace("<idUsuario>", $idUsuario, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Registra um evento de cadastro de usuário no sistema.
     * 
     * @param type $idUsuarioFonte Usuário que está cadastrando
     * @param type $idUsuarioAlvo Usuário que está sendo cadastrado
     */
    public static function registrarCadastroUsuario($idUsuarioFonte, $idUsuarioAlvo) {
        $quote = "\"";
        $sql = "INSERT INTO eventoSistema(idUsuario,idUsuarioAlvo,idTipoEventoSistema,data,hora) VALUES ";
        $sql .= " ($idUsuarioFonte,$idUsuarioAlvo,1,<data>,<hora>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

    /**
     * Registra um evento de remoção de um usuário do sistema.
     * @param type $idUsuarioFonte Usuário que está editando.
     * @param type $idUsuarioAlvo Usuário que está sendo editado.
     * @return boolean True em caso de sucesso, False em caso contrário.
     */
    public static function registrarExclusaoUsuario($idUsuarioFonte, $idUsuarioAlvo) {
        $quote = "\"";
        $sql = "INSERT INTO eventoSistema(idUsuario,idUsuarioAlvo,idTipoEventoSistema,data,hora) VALUES ";
        $sql .= " ($idUsuarioFonte,$idUsuarioAlvo,2,<data>,<hora>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

    /**
     * Registra um evento de alteração de um usuário do sistema.
     * @param type $idUsuarioFonte Usuário que está editando.
     * @param type $idUsuarioAlvo Usuário que está sendo editado.
     * @return boolean True em caso de sucesso, False em caso contrário.
     */
    public static function registrarAlteracaoUsuario($idUsuarioFonte, $idUsuarioAlvo) {
        $quote = "\"";
        $sql = "INSERT INTO eventoSistema(idUsuario,idUsuarioAlvo,idTipoEventoSistema,data,hora) VALUES ";
        $sql .= " ($idUsuarioFonte,$idUsuarioAlvo,3,<data>,<hora>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

}

?>
