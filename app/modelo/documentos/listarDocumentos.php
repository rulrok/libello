<?php

function listarOficios($tipo = 'todos') {
        $oficios = documentoDAO::consultar();
        $num_linhas = count($oficios);
        $retorno = '';
        for ($i = 0; $i < $num_linhas; $i++) {
            //se nao eh documento aproveitavel
            if (($oficios[$i]->getEstadoEdicao() == 0) && $tipo != 'emAberto') {
                //se eh documento invalido
                if ($oficios[$i]->getEstadoValidacao() == 0 && $tipo != 'validos') {
                    $retorno.= "<tr tipo='".$tipo."' doc='oficio'>";
                    $retorno.="<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->getIdOficio()) . '</td>';
                   // $retorno.="<td hidden class='campoID'>" . $oficios[$i]->getIdOficio() . '</td>';
                    $retorno.="<td width='30%' class='assunto'>" . $oficios[$i]->getAssunto() . "</td>";
                    $retorno.="<td width='30%' class='destino'>" . $oficios[$i]->getDestino() . "</td>";
                    $retorno.="<td width='10%' class='numeracao' align='center'>" . $oficios[$i]->getNumOficio() . "</td>";
                    $retorno.="<td  class='data' align='center'>" . $oficios[$i]->getData() . "</td>";
                    $retorno.="<td  class='validacao' align='center'>" . "Inválido" . "</td>";
                    $retorno.="</tr>";
                    //se eh valido
                } else if ($oficios[$i]->getEstadoValidacao() != 0 && $tipo != 'invalidos') {
                    $retorno.="<tr tipo='".$tipo."' doc='oficio'>";
                    $retorno.="<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->getIdOficio()) . '</td>';
                    //$retorno.="<td hidden class='campoID'>" . $oficios[$i]->getIdOficio() . '</td>';
                    $retorno.="<td width='30%' class='assunto'>" . $oficios[$i]->getAssunto() . "</td>";
                    $retorno.="<td width='30%' class='destino'>" . $oficios[$i]->getDestino() . "</td>";
                    $retorno.="<td width='10%' class='numeracao' align='center'>" . $oficios[$i]->getNumOficio() . "</td>";
                    $retorno.="<td  class='data' align='center'>" . $oficios[$i]->getData() . "</td>";
                    $retorno.="<td  class='validacao' align='center'>" . "Válido" . "</td>";
                    $retorno.="</tr>";
                }
            } else if (($oficios[$i]->getEstadoEdicao() != 0) && ($tipo == 'emAberto' || $tipo == 'todos')) {
                if ($oficios[$i]->getIdUsuario() == $_SESSION['usuario']->get_id()) {
                    $retorno.="<tr tipo='".$tipo."' doc='oficio'>";
                    $retorno.="<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->getIdOficio()) . '</td>';
                    //$retorno.="<td hidden class='campoID'>" . $oficios[$i]->getIdOficio() . '</td>';
                    $retorno.="<td  class='assunto'>" . $oficios[$i]->getAssunto() . "</td>";
                    $retorno.="<td  class='destino'>" . $oficios[$i]->getDestino() . "</td>";
                    $retorno.="<td  class='numeracao' align='center'>" . "Em aberto" . "</td>";
                    $retorno.="<td  class='data' align='center'>" . $oficios[$i]->getData() . "</td>";
                    $retorno.="<td  class='validacao' align='center'>" . "Válido" . "</td>";
                    $retorno.="</tr>";
                }
            }
        }
        return $retorno;
    }

    function listarMemorandos($tipo = 'todos') {
        $oficios = documentoDAO::consultar('memorando');
        $num_linhas = count($oficios);
        
        $retorno ='';
        
        for ($i = 0; $i < $num_linhas; $i++) {
            //se nao eh documento aproveitavel
            if ($oficios[$i]->getEstadoEdicao() == 0 && $tipo !='emAberto') {
                //se eh documento invalido
                if ($oficios[$i]->getEstadoValidacao() == 0 && $tipo !='validos') {
                    $retorno.= "<tr tipo='".$tipo."' doc='memorando'>";
                    $retorno.= "<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->getIdMemorando()) . '</td>';
                    //$retorno.= "<td hidden class='campoID'>" . $oficios[$i]->getIdMemorando() . '</td>';
                    $retorno.= "<td  class='assunto'>" . $oficios[$i]->getAssunto() . "</td>";
                    $retorno.= "<td  class='destino'>" . $oficios[$i]->getCargo_destino() . "</td>";
                    $retorno.= "<td  class='numeracao' align='center'>" . $oficios[$i]->getNumMemorando() . "</td>";
                    $retorno.= "<td  class='data' align='center'>" . $oficios[$i]->getData() . "</td>";
                    $retorno.= "<td  class='validacao' align='center'>" . "Inválido" . "</td>";
                    //se eh valido
                    $retorno.= '</tr>';
                } else if ($oficios[$i]->getEstadoValidacao() != 0 && $tipo !='invalidos'){
                    $retorno.= "<tr tipo='".$tipo."' doc='memorando'>";
                    $retorno.= "<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->getIdMemorando()) . '</td>';
                    $retorno.= "<td  class='assunto'>" . $oficios[$i]->getAssunto() . "</td>";
                    $retorno.= "<td  class='destino'>" . $oficios[$i]->getCargo_destino() . "</td>";
                    $retorno.= "<td  class='numeracao' align='center'>" . $oficios[$i]->getNumMemorando() . "</td>";
                    $retorno.= "<td  class='data' align='center'>" . $oficios[$i]->getData() . "</td>";
                    $retorno.= "<td  class='validacao' align='center'>" . "Válido" . "</td>";
                    $retorno.= '</tr>';
                }
            } else if (($oficios[$i]->getEstadoEdicao() != 0) && ($tipo =='emAberto' || $tipo== 'todos')) {
                if ($oficios[$i]->getIdUsuario() == $_SESSION['usuario']->get_id()) {
                    $retorno.= "<tr tipo='".$tipo."' doc='memorando'>";
                    $retorno.= "<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->getIdMemorando()) . '</td>';
                    //$retorno.= "<td hidden class='campoID'>" . $oficios[$i]->getIdMemorando() . '</td>';
                    $retorno.= "<td  class='assunto'>" . $oficios[$i]->getAssunto() . "</td>";
                    $retorno.= "<td  class='destino'>" . $oficios[$i]->getCargo_destino() . "</td>";
                    $retorno.= "<td  class='numeracao' align='center'>" . "Em aberto" . "</td>";
                    $retorno.= "<td  class='data' align='center'>" . $oficios[$i]->getData() . "</td>";
                    $retorno.= "<td  class='validacao' align='center'>" . "Válido" . "</td>";
                    $retorno.= '</tr>';
                }
            }
        }
        return $retorno;
    }
?>
