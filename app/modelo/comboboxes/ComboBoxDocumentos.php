<?php

require_once APP_LIBRARY_DIR . "configuracoes.php";

class ComboBoxDocumentos {
    
    public static function comboDia() {
        return "<select id='dia' name='dia'>
                
            </select>";
    }

    //combo mês
    public static function comboMes() {
        return "<select id='mes' name='mes'>
                <option id='janeiro' value='01'>janeiro</option>
                <option id='fevereiro' value='02'>fevereiro</option>
                <option id='marco' value='03'>março</option>
                <option id='abril' value='04'>abril</option>
                <option id='maio' value='05'>maio</option>
                <option id='junho' value='06'>junho</option>
                <option id='julho' value='07'>julho</option>
                <option id='agosto' value='08'>agosto</option>
                <option id='setembro' value='09'>setembro</option>
                <option id='outubro' value='10'>outubro</option>
                <option id='novembro' value='11'>novembro</option>
                <option id='dezembro' value='12'>dezembro</option>
            </select>";
    }
    
}

?>
