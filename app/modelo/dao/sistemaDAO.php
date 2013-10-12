<?php

require_once 'abstractDAO.php';
include_once __DIR__ . '/../enumeracao/TipoEventoSistema.php';

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

// <editor-fold defaultstate="collapsed" desc="Registro de atividade para ferramenta de usuários">

    /**
     * Registra um evento de cadastro de usuário no sistema.
     * 
     * @param type $idUsuarioFonte Usuário que está cadastrando
     * @param type $idUsuarioAlvo Usuário que está sendo cadastrado
     */
    public static function registrarCadastroUsuario($idUsuarioFonte, $idUsuarioAlvo) {
        $quote = "\"";
        $tipo = TipoEventoSistema::CADASTRO_USUARIO;
        $sql = "INSERT INTO eventoSistema(idUsuario,idUsuarioAlvo,idTipoEventoSistema,data,hora) VALUES ";
        $sql .= " ($idUsuarioFonte,$idUsuarioAlvo,$tipo,<data>,<hora>)";
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
    public static function registrarDesativacaoUsuario($idUsuarioFonte, $idUsuarioAlvo) {
        $quote = "\"";
        $tipo = TipoEventoSistema::REMOCAO_USUARIO;
        $sql = "INSERT INTO eventoSistema(idUsuario,idUsuarioAlvo,idTipoEventoSistema,data,hora) VALUES ";
        $sql .= " ($idUsuarioFonte,$idUsuarioAlvo,$tipo,<data>,<hora>)";
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

    public static function registrarExclusaoCurso($idUsuarioFonte) {
        $quote = "\"";
        $tipo = TipoEventoSistema::REMOCAO_CURSO;
        $sql = "INSERT INTO eventoSistema(idUsuario,idUsuarioAlvo,idTipoEventoSistema,data,hora) VALUES ";
        $sql .= " ($idUsuarioFonte,NULL,$tipo,<data>,<hora>)";
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

    public static function registrarExclusaoPolo($idUsuarioFonte) {
        $quote = "\"";
        $tipo = TipoEventoSistema::REMOCAO_POLO;
        $sql = "INSERT INTO eventoSistema(idUsuario,idUsuarioAlvo,idTipoEventoSistema,data,hora) VALUES ";
        $sql .= " ($idUsuarioFonte,NULL,$tipo,<data>,<hora>)";
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

    public static function registrarExclusaoEquipamento($idUsuarioFonte) {
        $quote = "\"";
        $tipo = TipoEventoSistema::REMOCAO_EQUIPAMENTO;
        $sql = "INSERT INTO eventoSistema(idUsuario,idUsuarioAlvo,idTipoEventoSistema,data,hora) VALUES ";
        $sql .= " ($idUsuarioFonte,NULL,$tipo,<data>,<hora>)";
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
        $tipo = TipoEventoSistema::ALTERACAO_USUARIO;
        $sql = "INSERT INTO eventoSistema(idUsuario,idUsuarioAlvo,idTipoEventoSistema,data,hora) VALUES ";
        $sql .= " ($idUsuarioFonte,$idUsuarioAlvo,$tipo,<data>,<hora>)";
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

// </editor-fold>
?>
