<?php

namespace app\modelo\ferramentas\usuarios;

require_once APP_DIR . "modelo/PaginaDeAcao.php";

use \app\modelo as Modelo;

class consultarpermissoes extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $usuarioDAO = new Modelo\usuarioDAO();
        $idUsuario = fnDecrypt(filter_input(INPUT_GET, 'userID'));
        $email = $usuarioDAO->descobrirEmail($idUsuario);

        if ($email != NULL) {
            $usuario = $usuarioDAO->recuperarUsuario($email, true);
            if ($usuario instanceof \app\modelo\Usuario) {
                $titulo = "Usuário: " . $usuario->get_PNome() . " " . $usuario->get_UNome();
                $this->adicionarMensagemPersonalizada("sys_modal_header", $titulo);

                $resultado = $usuarioDAO->obterPermissoes($idUsuario, true);
                $tabela = "<table class='tabelaPermissoes centralizado'>
                <tr>
                    <th>Ferramenta</th>
                    <th>Permissão</th>
                </tr>";
                foreach ($resultado as $permissao_ferramenta) {
                    $tabela .= '<tr>';
                    $tabela .= '<td>' . $permissao_ferramenta['nome'] . "</td><td>" . $permissao_ferramenta['tipo'] . "</td>";
                    $tabela .= '</tr>';
                }

                $tabela .= "</table>";
                $this->adicionarMensagemPersonalizada("sys_modal_body", $tabela);
            } else {
                $this->adicionarMensagemErro("Usuário não encontrado");
            }
        } else {
            $this->adicionarMensagemErro("Email não encontrado");
        }
    }

}
?>