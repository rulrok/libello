<?php



include APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/Oficio.php";
include APP_LOCATION . "visao/verificadorFormularioAjax.php";



class verificaratualizacaooficio extends verificadorFormularioAjax {
    
    
    public function _validar() {
        try{
                $idusuario = $_SESSION['usuario']->get_idUsuario();
                $idOficio = $_REQUEST['i_idoficio'];
                $numOficio = $_REQUEST['i_numOficio'];
                $assunto = $_REQUEST['assunto'];
                $corpo = $_REQUEST['corpo'];
                $destino = $_REQUEST['destino'];
                $referencia = $_REQUEST['referencia'];
                $dia = $_REQUEST['dia'];
                $mes = $_REQUEST['mes'];
                $ano = date('Y');
                $data = $dia . '/' . $mes . '/' . $ano;
                $tipoSigla = $_REQUEST['sigla'];
                $remetente = $_REQUEST['remetente'];
                $cargo_remetente = $_REQUEST['cargo_remetente'];

                $remetente2 = '';
                $cargo_remetente2 = '';
                $i_remetente = $_REQUEST['i_remetente'];


                if ($i_remetente == '1') {
                    $remetente2 = $_REQUEST['remetente2'];
                    $cargo_remetente2 = $_REQUEST['cargo_remetente2'];
                }else{
                    $remetente2 = null;
                    $cargo_remetente2 = null;
                }


                $tratamento = $_REQUEST['tratamento'];
                $cargo_destino = $_REQUEST['cargo_destino'];

                $documento = new Oficio();
                $documento->setIdOficio($idOficio);
                $documento->setAssunto($assunto);
                $documento->setIdUsuario(trim($idusuario));
                $documento->setCorpo($corpo);
                $documento->setDestino($destino);
                $documento->setReferencia($referencia);
                $documento->setData($data);
                $documento->setTipoSigla($tipoSigla);
                $documento->setRemetente($remetente);
                $documento->setCargo_remetente($cargo_remetente);
                $documento->setRemetente2($remetente2);
                $documento->setCargo_remetente2($cargo_remetente2);
                $documento->setTratamento($tratamento);
                $documento->setCargo_destino($cargo_destino);

                $estadoEdicao = 0;

                if ($numOficio == -1) {
                    $estadoEdicao = 1;
                }

                $documento->setEstadoEdicao($estadoEdicao);
                $documento->setNumOficio($numOficio);

                 documentoDAO::update_oficio($documento);
                if ($numOficio != -1) {
                    $this->mensagem->set_mensagem("Oficio gerado com sucesso!")->set_status(Mensagem::SUCESSO);

                }else{

                    $this->mensagem->set_mensagem("Oficio salvo com sucesso!")->set_status(Mensagem::SUCESSO);
                }

                $this->mensagem->id = fnEncrypt($idOficio);
            //return fnEncrypt($id);
        }
        catch(Exception $e){
            $this->mensagem->set_mensagem($e->getMessage())->set_status(Mensagem::ERRO);
        }
   
    }
//put your code here
}

$verificar = new verificaratualizacaooficio();
$verificar->verificar();

?>
