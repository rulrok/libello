<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';

class ControladorDocumento extends Controlador {

    public function acaoNovo() {
        $this->renderizar();
    }

    public function acaoSair() {
        $this->visao->conteudo = "Reuel";
        $this->renderizar();
    }

    public function acaoGerarOficio() {
        $this->renderizar();
    }
    public function acaoGerarMemorando(){
        $this->renderizar();
    }
    //comboDia() e comboMes() sao relativos a GerarOficio e Gerar Memorando
        //combo dia
        function comboDia() {
            echo "<select id='dia' name='dia'>
                <option value='01'>01</option>
                <option value='02'>02</option>
                <option value='03'>03</option>
                <option value='04'>04</option>
                <option value='05'>05</option>
                <option value='06'>06</option>
                <option value='07'>07</option>
                <option value='08'>08</option>
                <option value='09'>09</option>
                <option value='10'>10</option>
                <option value='11'>11</option>
                <option value='12'>12</option>
                <option value='13'>13</option>
                <option value='14'>14</option>
                <option value='15'>15</option>
                <option value='16'>16</option>
                <option value='17'>17</option>
                <option value='18'>18</option>
                <option value='19'>19</option>
                <option value='20'>20</option>
                <option value='21'>21</option>
                <option value='22'>22</option>
                <option value='23'>23</option>
                <option value='24'>24</option>
                <option value='25'>25</option>
                <option value='26'>26</option>
                <option value='27'>27</option>
                <option value='28'>28</option>
                <option value='29'>29</option>
                <option value='30'>30</option>
                <option value='31'>31</option>
            </select>";
        }

        //combo mês
        function comboMes() {
            echo "<select id='mes' name='mes'>
                <option value='01'>janeiro</option>
                <option value='02'>fevereiro</option>
                <option value='03'>março</option>
                <option value='04'>abril</option>
                <option value='05'>maio</option>
                <option value='06'>junho</option>
                <option value='07'>julho</option>
                <option value='08'>agosto</option>
                <option value='09'>setembro</option>
                <option value='10'>outubro</option>
                <option value='11'>novembro</option>
                <option value='12'>dezembro</option>
            </select>";
        }
        
       
        
}

?>
