<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";

class ComboBoxUsuarios {

    /**
     * Retorna uma listagem, separando por grupos de usuários (e.g Gestores, Administrador), de todos os usuário cadastrados no sistema
     * para ser usado dentro de um componente <select>
     * @return string
     */
    public static function listarTodosUsuarios() {
        $codigo = "";
        $usuarioDAO = new usuarioDAO();
        $papelDAO = new papelDAO();
        for ($i = 1; $i <= Papel::__length; $i++) {
            $usuarios = $usuarioDAO->consultar("idUsuario,concat(PNome,' ',UNome) as Nome,email", "idPapel = :idPapel", array(':idPapel' => array($i, PDO::PARAM_INT)));
            if (sizeof($usuarios) == 0) {
                continue;
            } else {
                $nomePapel = $papelDAO->obterNomePapel($i);
//            $codigo .= "<option value=\"default\" selected=\"selected\"> -- Selecione uma opção --</option>\n";
                $codigo .= "<optgroup label='$nomePapel'>\n";
                for ($j = 0; $j < sizeof($usuarios); $j++) {
                    $codigo .= "<option value=\"" . fnEncrypt($usuarios[$j]['idUsuario']) . "\">" . $usuarios[$j]['Nome'] . " (" . $usuarios[$j]['email'] . ")</option>\n";
                }
                $codigo .= "</optgroup>\n";
            }
        }
        return $codigo;
    }

}

?>
