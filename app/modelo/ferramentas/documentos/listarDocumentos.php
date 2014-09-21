<?php

/**
 * 
 * @param type $tipo por default, preenche a tabela "todos" 
 * @return string contendo o html montado já com os dados vindos do BD
 */
function listarOficios($tipo = 'todos') {
        $oficios = (new \app\modelo\documentoDAO())->consultar();
        $num_linhas = count($oficios);
        $retorno = '';
        for ($i = 0; $i < $num_linhas; $i++) {
            //se nao eh documento aproveitavel
            if (($oficios[$i]->get_estadoEdicao() == 0) && $tipo != 'emAberto') {
                //se eh documento invalido
                if ($oficios[$i]->get_estadoValidacao() == 0 && $tipo != 'validos') {
                    $retorno.= "<tr tipo='".$tipo."' doc='oficio'>";
                    $retorno.="<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->get_idOficio()) . '</td>';
                   // $retorno.="<td hidden class='campoID'>" . $oficios[$i]->get_idOficio() . '</td>';
                    $retorno.="<td width='30%' class='assunto'>" . $oficios[$i]->get_assunto() . "</td>";
                    $retorno.="<td width='30%' class='destino'>" . $oficios[$i]->get_destino() . "</td>";
                    $retorno.="<td width='10%' class='numeracao' align='center'>" . $oficios[$i]->get_numOficio() . "</td>";
                    $retorno.="<td  class='data' align='center'>" . $oficios[$i]->get_data() . "</td>";
                    $retorno.="<td  class='validacao' align='center'>" . "Inválido" . "</td>";
                    $retorno.="</tr>";
                    //se eh valido
                } else if ($oficios[$i]->get_estadoValidacao() != 0 && $tipo != 'invalidos') {
                    $retorno.="<tr tipo='".$tipo."' doc='oficio'>";
                    $retorno.="<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->get_idOficio()) . '</td>';
                    //$retorno.="<td hidden class='campoID'>" . $oficios[$i]->get_idOficio() . '</td>';
                    $retorno.="<td width='30%' class='assunto'>" . $oficios[$i]->get_assunto() . "</td>";
                    $retorno.="<td width='30%' class='destino'>" . $oficios[$i]->get_destino() . "</td>";
                    $retorno.="<td width='10%' class='numeracao' align='center'>" . $oficios[$i]->get_numOficio() . "</td>";
                    $retorno.="<td  class='data' align='center'>" . $oficios[$i]->get_data() . "</td>";
                    $retorno.="<td  class='validacao' align='center'>" . "Válido" . "</td>";
                    $retorno.="</tr>";
                }
            } else if (($oficios[$i]->get_estadoEdicao() != 0) && ($tipo == 'emAberto' || $tipo == 'todos')) {
                if ($oficios[$i]->get_idUsuario() == obterUsuarioSessao()->get_idUsuario()) {
                    $retorno.="<tr tipo='".$tipo."' doc='oficio'>";
                    $retorno.="<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->get_idOficio()) . '</td>';
                    //$retorno.="<td hidden class='campoID'>" . $oficios[$i]->get_idOficio() . '</td>';
                    $retorno.="<td  class='assunto'>" . $oficios[$i]->get_assunto() . "</td>";
                    $retorno.="<td  class='destino'>" . $oficios[$i]->get_destino() . "</td>";
//                    $retorno.="<td  class='numeracao' align='center'>" . "Em aberto" . "</td>";
                    $retorno.="<td  class='numeracao' align='center'>" . $oficios[$i]->get_numOficio() . "</td>";
                    $retorno.="<td  class='data' align='center'>" . $oficios[$i]->get_data() . "</td>";
//                    $retorno.="<td  class='validacao' align='center'>" . "Válido" . "</td>";
                    $retorno.="<td  class='validacao' align='center'>" . "Em aberto" . "</td>";
                    $retorno.="</tr>";
                }
            }
        }
        return $retorno;
    }

    function listarMemorandos($tipo = 'todos') {
        $oficios = (new \app\modelo\documentoDAO())->consultar('documento_memorando');
        $num_linhas = count($oficios);
        
        $retorno ='';
        
        for ($i = 0; $i < $num_linhas; $i++) {
            //se nao eh documento aproveitavel
            if ($oficios[$i]->get_estadoEdicao() == 0 && $tipo !='emAberto') {
                //se eh documento invalido
                if ($oficios[$i]->get_estadoValidacao() == 0 && $tipo !='validos') {
                    $retorno.= "<tr tipo='".$tipo."' doc='memorando'>";
                    $retorno.= "<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->get_idMemorando()) . '</td>';
                    //$retorno.= "<td hidden class='campoID'>" . $oficios[$i]->get_idMemorando() . '</td>';
                    $retorno.= "<td  class='assunto'>" . $oficios[$i]->get_assunto() . "</td>";
                    $retorno.= "<td  class='destino'>" . $oficios[$i]->get_cargo_destino() . "</td>";
                    $retorno.= "<td  class='numeracao' align='center'>" . $oficios[$i]->get_numMemorando() . "</td>";
                    $retorno.= "<td  class='data' align='center'>" . $oficios[$i]->get_data() . "</td>";
                    $retorno.= "<td  class='validacao' align='center'>" . "Inválido" . "</td>";
                    //se eh valido
                    $retorno.= '</tr>';
                } else if ($oficios[$i]->get_estadoValidacao() != 0 && $tipo !='invalidos'){
                    $retorno.= "<tr tipo='".$tipo."' doc='memorando'>";
                    $retorno.= "<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->get_idMemorando()) . '</td>';
                    $retorno.= "<td  class='assunto'>" . $oficios[$i]->get_assunto() . "</td>";
                    $retorno.= "<td  class='destino'>" . $oficios[$i]->get_cargo_destino() . "</td>";
                    $retorno.= "<td  class='numeracao' align='center'>" . $oficios[$i]->get_numMemorando() . "</td>";
                    $retorno.= "<td  class='data' align='center'>" . $oficios[$i]->get_data() . "</td>";
                    $retorno.= "<td  class='validacao' align='center'>" . "Válido" . "</td>";
                    $retorno.= '</tr>';
                }
            } else if (($oficios[$i]->get_estadoEdicao() != 0) && ($tipo =='emAberto' || $tipo== 'todos')) {
                if ($oficios[$i]->get_idUsuario() == obterUsuarioSessao()->get_idUsuario()) {
                    $retorno.= "<tr tipo='".$tipo."' doc='memorando'>";
                    $retorno.= "<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->get_idMemorando()) . '</td>';
                    //$retorno.= "<td hidden class='campoID'>" . $oficios[$i]->get_idMemorando() . '</td>';
                    $retorno.= "<td  class='assunto'>" . $oficios[$i]->get_assunto() . "</td>";
                    $retorno.= "<td  class='destino'>" . $oficios[$i]->get_cargo_destino() . "</td>";
//                    $retorno.= "<td  class='numeracao' align='center'>" . "Em aberto" . "</td>";
                    $retorno.= "<td  class='numeracao' align='center'>" . $oficios[$i]->get_numMemorando()  . "</td>";
                    $retorno.= "<td  class='data' align='center'>" . $oficios[$i]->get_data() . "</td>";
//                    $retorno.= "<td  class='validacao' align='center'>" . "Válido" . "</td>";
                    $retorno.= "<td  class='validacao' align='center'>" . "Em aberto" . "</td>";
                    $retorno.= '</tr>';
                }
            }
        }
        return $retorno;
    }

//function listarOficios() {
//        $oficios = (new documentoDAO())->consultar();
//        $num_linhas = count($oficios);
//        $retorno = '';
//        for ($i = 0; $i < $num_linhas; $i++) {
//            //se nao eh documento aproveitavel
//            if (($oficios[$i]->get_estadoEdicao() == 0)) {
//                //se eh documento invalido
//                if ($oficios[$i]->get_estadoValidacao() == 0) {
//                    $retorno.= "<tr tipo='".$tipo."' doc='oficio'>";
//                    $retorno.="<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->get_idOficio()) . '</td>';
//                   // $retorno.="<td hidden class='campoID'>" . $oficios[$i]->get_idOficio() . '</td>';
//                    $retorno.="<td width='30%' class='assunto'>" . $oficios[$i]->get_assunto() . "</td>";
//                    $retorno.="<td width='30%' class='destino'>" . $oficios[$i]->get_destino() . "</td>";
//                    $retorno.="<td width='10%' class='numeracao' align='center'>" . $oficios[$i]->get_numOficio() . "</td>";
//                    $retorno.="<td  class='data' align='center'>" . $oficios[$i]->get_data() . "</td>";
//                    $retorno.="<td  class='validacao' align='center'>" . "Inválido" . "</td>";
//                    $retorno.="</tr>";
//                    //se eh valido
//                } else if ($oficios[$i]->get_estadoValidacao() != 0) {
//                    $retorno.="<tr tipo='".$tipo."' doc='oficio'>";
//                    $retorno.="<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->get_idOficio()) . '</td>';
//                    //$retorno.="<td hidden class='campoID'>" . $oficios[$i]->get_idOficio() . '</td>';
//                    $retorno.="<td width='30%' class='assunto'>" . $oficios[$i]->get_assunto() . "</td>";
//                    $retorno.="<td width='30%' class='destino'>" . $oficios[$i]->get_destino() . "</td>";
//                    $retorno.="<td width='10%' class='numeracao' align='center'>" . $oficios[$i]->get_numOficio() . "</td>";
//                    $retorno.="<td  class='data' align='center'>" . $oficios[$i]->get_data() . "</td>";
//                    $retorno.="<td  class='validacao' align='center'>" . "Válido" . "</td>";
//                    $retorno.="</tr>";
//                }
//            } else if (($oficios[$i]->get_estadoEdicao() != 0)) {
//                if ($oficios[$i]->get_idUsuario() == obterUsuarioSessao()->get_idUsuario()) {
//                    $retorno.="<tr tipo='".$tipo."' doc='oficio'>";
//                    $retorno.="<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->get_idOficio()) . '</td>';
//                    //$retorno.="<td hidden class='campoID'>" . $oficios[$i]->get_idOficio() . '</td>';
//                    $retorno.="<td  class='assunto'>" . $oficios[$i]->get_assunto() . "</td>";
//                    $retorno.="<td  class='destino'>" . $oficios[$i]->get_destino() . "</td>";
//                    $retorno.="<td  class='numeracao' align='center'>" . "Em aberto" . "</td>";
//                    $retorno.="<td  class='data' align='center'>" . $oficios[$i]->get_data() . "</td>";
//                    $retorno.="<td  class='validacao' align='center'>" . "Válido" . "</td>";
//                    $retorno.="</tr>";
//                }
//            }
//        }
//        return $retorno;
//    }
//
//    function listarMemorandos() {
//        $oficios = (new documentoDAO())->consultar('documento_memorando');
//        $num_linhas = count($oficios);
//        
//        $retorno ='';
//        
//        for ($i = 0; $i < $num_linhas; $i++) {
//            //se nao eh documento aproveitavel
//            if ($oficios[$i]->get_estadoEdicao() == 0 ) {
//                //se eh documento invalido
//                if ($oficios[$i]->get_estadoValidacao() == 0) {
//                    $retorno.= "<tr tipo='".$tipo."' doc='memorando'>";
//                    $retorno.= "<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->get_idMemorando()) . '</td>';
//                    //$retorno.= "<td hidden class='campoID'>" . $oficios[$i]->get_idMemorando() . '</td>';
//                    $retorno.= "<td  class='assunto'>" . $oficios[$i]->get_assunto() . "</td>";
//                    $retorno.= "<td  class='destino'>" . $oficios[$i]->get_cargo_destino() . "</td>";
//                    $retorno.= "<td  class='numeracao' align='center'>" . $oficios[$i]->get_numMemorando() . "</td>";
//                    $retorno.= "<td  class='data' align='center'>" . $oficios[$i]->get_data() . "</td>";
//                    $retorno.= "<td  class='validacao' align='center'>" . "Inválido" . "</td>";
//                    //se eh valido
//                    $retorno.= '</tr>';
//                } else if ($oficios[$i]->get_estadoValidacao() != 0){
//                    $retorno.= "<tr tipo='".$tipo."' doc='memorando'>";
//                    $retorno.= "<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->get_idMemorando()) . '</td>';
//                    $retorno.= "<td  class='assunto'>" . $oficios[$i]->get_assunto() . "</td>";
//                    $retorno.= "<td  class='destino'>" . $oficios[$i]->get_cargo_destino() . "</td>";
//                    $retorno.= "<td  class='numeracao' align='center'>" . $oficios[$i]->get_numMemorando() . "</td>";
//                    $retorno.= "<td  class='data' align='center'>" . $oficios[$i]->get_data() . "</td>";
//                    $retorno.= "<td  class='validacao' align='center'>" . "Válido" . "</td>";
//                    $retorno.= '</tr>';
//                }
//            } else if (($oficios[$i]->get_estadoEdicao() != 0)) {
//                if ($oficios[$i]->get_idUsuario() == obterUsuarioSessao()->get_idUsuario()) {
//                    $retorno.= "<tr tipo='".$tipo."' doc='memorando'>";
//                    $retorno.= "<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->get_idMemorando()) . '</td>';
//                    //$retorno.= "<td hidden class='campoID'>" . $oficios[$i]->get_idMemorando() . '</td>';
//                    $retorno.= "<td  class='assunto'>" . $oficios[$i]->get_assunto() . "</td>";
//                    $retorno.= "<td  class='destino'>" . $oficios[$i]->get_cargo_destino() . "</td>";
//                    $retorno.= "<td  class='numeracao' align='center'>" . "Em aberto" . "</td>";
//                    $retorno.= "<td  class='data' align='center'>" . $oficios[$i]->get_data() . "</td>";
//                    $retorno.= "<td  class='validacao' align='center'>" . "Válido" . "</td>";
//                    $retorno.= '</tr>';
//                }
//            }
//        }
//        return $retorno;
//    }
?>
