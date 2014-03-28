<?php

require_once BIBLIOTECA_DIR . "configuracoes.php";
require_once APP_DIR . 'modelo/dao/usuarioDAO.php';
require_once APP_DIR . 'modelo/enumeracao/Papel.php';

class ComboBoxUsuarios {

    const LISTAR_APENAS_NOMES = 0;
    const LISTAR_COM_EMAIL = 1;
    const LISTAR_COM_CPF = 2;

    /**
     * Retorna uma listagem, separando por grupos de usuários (e.g Gestores, Administrador), de todos os usuário cadastrados no sistema
     * para ser usado dentro de um componente <select>
     * @return string
     */
    public static function listarTodosUsuarios($listagem = self::LISTAR_COM_EMAIL, $opcaoPadrao = null) {
        if ($opcaoPadrao === null) {
            $codigo = "";
        } else {
            $codigo = "<option value='default'>$opcaoPadrao</option>";
        }
        $usuarioDAO = new usuarioDAO();
        $papelDAO = new papelDAO();
        switch ($listagem) {
            case self::LISTAR_APENAS_NOMES:
                $campoExtra = null;
                break;
            case self::LISTAR_COM_EMAIL:
                $campoExtra = "email";
                break;
            case self::LISTAR_COM_CPF:
                $campoExtra = "cpf";
                break;
        }
        for ($i = 1; $i <= Papel::__length; $i++) {
            if ($campoExtra !== null) {
                $usuarios = $usuarioDAO->consultar("idUsuario,concat_ws(' ',PNome,UNome) as Nome, $campoExtra", "idPapel = :idPapel", array(':idPapel' => array($i, PDO::PARAM_INT)));
            } else {
                $usuarios = $usuarioDAO->consultar("idUsuario,concat_ws(' ',PNome,UNome) as Nome", "idPapel = :idPapel", array(':idPapel' => array($i, PDO::PARAM_INT)));
            }
            if (sizeof($usuarios) == 0) {
                continue;
            } else {
                $nomePapel = $papelDAO->obterNomePapel($i);
//            $codigo .= "<option value=\"default\" selected=\"selected\"> -- Selecione uma opção --</option>\n";
                $codigo .= "<optgroup label='$nomePapel'>\n";
                if ($campoExtra !== null) {
                    for ($j = 0; $j < sizeof($usuarios); $j++) {
                        $codigo .= "<option value=\"" . fnEncrypt($usuarios[$j]['idUsuario']) . "\">" . $usuarios[$j]['Nome'] . " ( " . $usuarios[$j][$campoExtra] . " )</option>\n";
                    }
                } else {
                    for ($j = 0; $j < sizeof($usuarios); $j++) {
                        $codigo .= "<option value=\"" . fnEncrypt($usuarios[$j]['idUsuario']) . "\">" . $usuarios[$j]['Nome'] . "</option>\n";
                    }
                }
                $codigo .= "</optgroup>\n";
            }
        }
        return $codigo;
    }

}

?>
