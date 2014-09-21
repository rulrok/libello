<?php
namespace app\modelo;

require_once APP_LIBRARY_DIR . "configuracoes.php";
require_once APP_DIR . 'modelo/dao/poloDAO.php';

class ComboBoxPolo {

    public static function montarTodosOsPolos($tipo = null) {
        $rodrigo;
        $codigo = "";
        $polos = (new \app\modelo\poloDAO())->consultar();
        if (sizeof($polos) == 0) {
            $codigo .= '<option value="default" selected="selected"> -- Não existem polos cadastrados --</option>';
        } else {
            if(!$tipo){
                $codigo .= '<option value="default" selected="selected"> -- Selecione um descritor --</option>';
            }else{
                $codigo .= '<option value="default" selected="selected">Selecionado: '.$tipo.'</option>';
            }
            $codigo .= '<optgroup label="Polos">';
            for ($i = 0; $i < sizeof($polos); $i++) {
                $codigo .= "<option value=\"" . fnEncrypt($polos[$i]['idPolo']) . "\">" . $polos[$i]['nomePolo'] . "</option>";
            }
        }
        $codigo .= "</optgroup>";
        return $codigo;
    }

}

?>
