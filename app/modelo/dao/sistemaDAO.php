<?php

require_once 'abstractDAO.php';
require_once APP_DIR . 'modelo/enumeracao/TipoEventoSistema.php';
require_once APP_DIR . 'modelo/Utils.php';

class sistemaDAO extends abstractDAO {

    public function registrarAccesso($idUsuario) {
        $sql = "INSERT INTO usuario_acessos(idUsuario,data,ip) VALUES (:idU, :d, :ip)";
        $params = array(
            ':idU' => [$idUsuario, PDO::PARAM_INT]
            , ':d' => [time(), PDO::PARAM_INT]
            , ':ip' => [$_SERVER['REMOTE_ADDR'], PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

// <editor-fold defaultstate="collapsed" desc="Registro de atividade para ferramenta de usuários">

    /**
     * Registra um evento de cadastro de usuário no sistema.
     * 
     * @param type $idUsuarioFonte Usuário que está cadastrando
     * @param type $idUsuarioAlvo Usuário que está sendo cadastrado
     */
    public function registrarCadastroUsuario($idUsuarioFonte, $idUsuarioAlvo) {
        $tipo = TipoEventoSistema::CADASTRO_USUARIO;
        $sql = "INSERT INTO sistema_eventosistema(idUsuario,idUsuarioAlvo,idTipoEventoSistema,data) VALUES (:idUF, :idUA, :t, :d)";
        $params = array(
            ':idUF' => [$idUsuarioFonte, PDO::PARAM_INT]
            , ':idUA' => [$idUsuarioAlvo, PDO::PARAM_INT]
            , ':t' => [$tipo, PDO::PARAM_INT]
            , ':d' => [time(), PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

    /**
     * Registra um evento de remoção de um usuário do sistema.
     * @param type $idUsuarioFonte Usuário que está editando.
     * @param type $idUsuarioAlvo Usuário que está sendo editado.
     * @return boolean True em caso de sucesso, False em caso contrário.
     */
    public function registrarDesativacaoUsuario($idUsuarioFonte, $idUsuarioAlvo) {
        $tipo = TipoEventoSistema::DESATIVACAO_USUARIO;
        $sql = "INSERT INTO sistema_eventosistema(idUsuario,idUsuarioAlvo,idTipoEventoSistema,data) VALUES (:idUF, :idUA,:t, :d)";
        $params = array(
            ':idUF' => [$idUsuarioFonte, PDO::PARAM_INT]
            , ':idUA' => [$idUsuarioAlvo, PDO::PARAM_INT]
            , ':t' => [$tipo, PDO::PARAM_INT]
            , ':d' => [time(), PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function registrarAtivacaoUsuario($idUsuarioFonte, $idUsuarioAlvo) {
        $tipo = TipoEventoSistema::ATIVACAO_USUARIO;
        $sql = "INSERT INTO sistema_eventosistema(idUsuario,idUsuarioAlvo,idTipoEventoSistema,data) VALUES (:idUF, :idUA,:t, :d)";
        $params = array(
            ':idUF' => [$idUsuarioFonte, PDO::PARAM_INT]
            , ':idUA' => [$idUsuarioAlvo, PDO::PARAM_INT]
            , ':t' => [$tipo, PDO::PARAM_INT]
            , ':d' => [time(), PDO::PARAM_INT]
        );
        return $this->executarQuery($sql, $params);
    }

    public function registrarExclusaoCurso($idUsuarioFonte) {
        $tipo = TipoEventoSistema::REMOCAO_CURSO;
        $sql = "INSERT INTO sistema_eventosistema(idUsuario,idUsuarioAlvo,idTipoEventoSistema,data) VALUES (:idUF, NULL, :t,:d)";
        $params = array(
            ':idUF' => [$idUsuarioFonte, PDO::PARAM_INT]
            , ':t' => [$tipo, PDO::PARAM_INT]
            , ':d' => [time(), PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

    public function registrarExclusaoPolo($idUsuarioFonte) {
        $tipo = TipoEventoSistema::REMOCAO_POLO;
        $sql = "INSERT INTO sistema_eventosistema(idUsuario,idUsuarioAlvo,idTipoEventoSistema,data) VALUES (:idUF, NULL, :t, :d)";
        $params = array(
            ':idUF' => [$idUsuarioFonte, PDO::PARAM_INT]
            , ':t' => [$tipo, PDO::PARAM_INT]
            , ':d' => [time(), PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

    /**
     * Registra um evento de alteração de um usuário do sistema.
     * @param type $idUsuarioFonte Usuário que está editando.
     * @param type $idUsuarioAlvo Usuário que está sendo editado.
     * @return boolean True em caso de sucesso, False em caso contrário.
     */
    public function registrarAlteracaoUsuario($idUsuarioFonte, $idUsuarioAlvo) {
        $tipo = TipoEventoSistema::ALTERACAO_USUARIO;
        $sql = "INSERT INTO sistema_eventosistema(idUsuario,idUsuarioAlvo,idTipoEventoSistema,data) VALUES (:idUF,:idUA,:t,:d)";
        $params = array(
            ':idUF' => [$idUsuarioFonte, PDO::PARAM_INT]
            , ':idUA' => [$idUsuarioAlvo, PDO::PARAM_INT]
            , ':t' => [$tipo, PDO::PARAM_INT]
            , ':d' => [time(), PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

}

// </editor-fold>
?>
