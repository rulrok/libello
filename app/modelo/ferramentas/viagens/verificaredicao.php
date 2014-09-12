<?php
require_once APP_DIR . "modelo/vo/Viagem.php";
require_once APP_DIR . "visao/verificadorFormularioAjax.php";

class verificarEdicao extends verificadorFormularioAjax{
    public function _validar(){
        $idViagem = fnDecrypt(filter_input(INPUT_POST, 'idViagem'));
        $idCurso = filter_input(INPUT_POST, 'idCurso',FILTER_VALIDATE_INT);
        $idPolo = filter_input(INPUT_POST, 'idPolo',FILTER_VALIDATE_INT);
        $responsavel = filter_input(INPUT_POST, 'responsavel');
        $dataIda = filter_input(INPUT_POST, 'dataIda');
        $horaIda = filter_input(INPUT_POST, 'horaIda');
        $dataVolta = filter_input(INPUT_POST, 'dataVolta');
        $horaVolta = filter_input(INPUT_POST, 'horaVolta');
        $motivo = filter_input(INPUT_POST, 'motivo');
        $estadoViagem = filter_input(INPUT_POST, 'estadoViagem');
        $diarias = filter_input(INPUT_POST, 'diarias');
        $outroDestino = filter_input(INPUT_POST, 'outroDestino');
        
        if($idCurso == ""){
            $this->mensagemErro("A viagem deve ser relacionada a algum curso.");
        }
        if($responsavel == ""){
            $this->mensagemErro("É obrigatório a escolha de um responsável.");
        }
        if($dataIda == ""){
            $this->mensagemErro("É necessário determinar uma data de saída.");
        }
        if($horaIda == ""){
            $this->mensagemErro("É necessário determinar o horário de saída.");
        }
        if($dataVolta == ""){
            $this->mensagemErro("É necessário determinar a data de retorno.");
        }
        if($horaVolta == ""){
            $this->mensagemErro("É necessário determinar a hora do retorno.");
        }
        if($motivo == ""){
            $this->mensagemErro("Não foi definido a razão da viagem.");
        }
        if($estadoViagem == ""){
            $this->mensagemErro("O estado da viagem não foi determinado.");
        }
        if($diarias == ""){
            $this->mensagemErro("O número de diárias não foi definido.");
        }
        if($idPolo === null && $outroDestino === null){
            $this->mensagemErro("A viagem deve ter um destino definido.");
        }
        
        $viagemDAO = new viagemDAO();
        $viagem = $viagemDAO->recuperarViagem($idViagem);
        
        if($diarias <= 0){
            $this->mensagemErro("O número de diarias deve ser positivo.");
        }
        if($outroDestino != ""){
            $viagem->set_outroDestino($outroDestino);
        }else{
            $viagem->set_idPolo($idPolo);
        }
        $viagem->set_idCurso($idCurso)->set_responsavel($responsavel)->set_dataIda($dataIda)->set_horaIda($horaIda)->set_dataVolta($dataVolta)->set_horaVolta($horaVolta)->set_motivo($motivo)->set_estado($estadoViagem)->set_diarias($diarias);
        
        if ($viagemDAO->atualizar($idViagem, $viagem)) {
            $this->mensagemSucesso("Atualizado com sucesso");
        } else {
            $this->mensagemErro("Um erro ocorreu ao cadastrar no banco");
        }
    }   
    
}

$verificarEdicao = new verificarEdicao();
$verificarEdicao->verificar();
?>