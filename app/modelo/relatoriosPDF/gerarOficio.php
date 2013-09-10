<?php

//define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
//incluindo o arquivo do fpdf
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/configuracoes.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/dompdf/dompdf_config.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/app/controlador/ControladorDocumentos.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/seguranca/seguranca.php");
//require_once '../controller/ControllerDoc.php';
//require_once '../seguranca.php';
//-------------------
//definindo variaveis
$idUsuario = $_SESSION['idUsuario'];
$numOficio = $_POST['i_numOficio'];
$tipoSigla = $_POST['sigla'];
$dia = $_POST['dia'];
$mes = $_POST['mes'];
$ano = date('Y');
$data = $dia . '/' . $mes . '/' . date('Y');
$tratamento = $_POST['tratamento'];
$destino = $_POST['destino'];
$cargo_destino = $_POST['cargo_destino'];
$assunto = $_POST['assunto'];
$referencia = $_POST['referencia'];
$corpo = $_POST['corpo'];
$remetente = $_POST['remetente'];
$cargo_remetente = $_POST['cargo_remetente'];
//Verifica se possui mais de um remetente e pega seu valor
$remetente2 = '';
$cargo_remetente2 = '';
$i_remetente = $_POST['i_remetente'];
if ($i_remetente == '1') {
    $remetente2 = $_POST['remetente2'];
    $cargo_remetente2 = $_POST['cargo_remetente2'];
}
//estadoEdicao - se for salvar 1, senão 0
$estadoEdicao = 0;
$cont = new ControladorDocumentos();
//salvando ou atualizando oficio no banco
$booledit = $_GET['booledit'];
if ($booledit == '1') {
    $idoficio = $_POST['i_idoficio'];
    $cont->atualizarOficio($idoficio, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio);

} else {
    $cont->novoOficio($idUsuario, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio);
}
$mes = retornaMes($_POST['mes']);
$data = $dia . '/' . $mes . '/' . date('Y');
//-------------------
//montando o documento
$document = '<<<EOF
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">       
        <head>
            <style>            
            html{
                margin: 48px 98px 0 94px;
                padding:0;
            }  
            
            .tabela{    
                width: 597px; /* 210mm */
                /* height: 1120px;  297mm */ 
                font-family:"Arial", Helvetica, sans-serif; 
                font-size: 15px; 
                background-color: #FFF;
                }
            </style>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        
        </head>
        <body>
            <table class="tabela">
                <tr>
                    <td style="width: 597px" align="center">
                        <img src="../../../publico/imagens/oficio/cabecalho.jpg"></img>
                    </td>
                </tr>
                <tr><td style="height: 30px;"></td></tr>
                <tr>
                    <td>
                        Ofício nº'.$numOficio.'/'.$ano.'/CEAD - ' . $tipoSigla . '
                    </td>
                </tr>
                <tr><td style="height: 40px;"></td></tr>
                <tr >
                    <td align="right">
                        Alfenas, ' . $dia . ' de ' . $mes . ' de ' . date("Y") . '
                    </td>
                </tr>
                <tr><td style="height: 40px;"></td></tr>
                <tr>
                    <td>
                        <span> ' . $tratamento . '</span>
                    </td>                
                </tr>
                <tr>
                    <td>
                        <span>' . $destino . '</span>
                    </td>
                </tr>                
                <tr>
                    <td>
                        <span>' . $cargo_destino . '</span>
                    </td>
                </tr>                                
                <tr><td style="height: 40px;"></td></tr>
                <tr>
                    <td>
                        Assunto: <span> ' . $assunto . '</span>
                    </td>
                </tr>
                <tr><td style="height: 40px;"></td></tr>
                <tr>
                    <td align="left">
                        <span>' . $referencia . '</span>
                    </td>
                </tr>                
                <tr><td style="height: 20px;"></td></tr>
                <tr>
                    <td align="left">
                        <div>
                            <span style="max-height: 500px;min-height: 200px;max-width: 625px;min-width: 625px">' . $corpo . '</span>
                        </div>
                    </td>
                </tr>
                <tr><td style="height: 40px;"></td></tr>
                <tr>
                    <td style="height: 20px;" align="left">
                        Atenciosamente,
                    </td>
                </tr>
                <tr><td style="height: 30px;"></td></tr>
                <tr>
                    <td>
                        <div id="div_remetente1" name="div_remetente1">
                            <table align="center">
                                <tr>
                                    <td style="height: 20px;">
                                        <span>____________________________________</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="height: 20px;">
                                        <span>' . $remetente . '</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="height: 20px;">
                                        <span> ' . $cargo_remetente . ' </span>
                                    </td>                                                    
                                </tr>
                            </table>
                        </div>';
                        if ($i_remetente == '1') {
    $document .= '<br></br>
                        <div id="div_remetente2" name="div_remetente2">
                            <table align="center">
                                <tr>
                                    <td style="height: 20px;">
                                        <span>____________________________________</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="height: 20px;">
                                        <span>' . $remetente2 . '</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="height: 20px;">
                                        <span> ' . $cargo_remetente2 . ' </span>
                                    </td>                                                    
                                </tr>
                            </table>
                        </div>';
}
$document .= '</table>
        </body>
    </html>';
//echo $document; die();
$dompdf = new DOMPDF();
//$tamanho = array(0, 0, 596.4, 843.48);
$dompdf->parse_default_view('A4', 'portrait');
$dompdf->set_paper('A4', 'portrait');
$dompdf->load_html($document);
$dompdf->render();
//$dompdf->;
$options = array(
    'Attachment' => 0
);
$dompdf->stream($ano." - Oficio n".$numOficio, $options);

return "algo";

function retornaMes($mes) {
    if ($mes == '01') {
        return 'janeiro';
    }
    if ($mes == '02') {
        return 'fevereiro';
    }
    if ($mes == '03') {
        return 'março';
    }
    if ($mes == '04') {
        return 'abril';
    }
    if ($mes == '05') {
        return 'maio';
    }
    if ($mes == '06') {
        return 'junho';
    }
    if ($mes == '07') {
        return 'julho';
    }
    if ($mes == '08') {
        return 'agosto';
    }
    if ($mes == '09') {
        return 'setembro';
    }
    if ($mes == '10') {
        return 'outubro';
    }
    if ($mes == '11') {
        return 'novembro';
    }
    if ($mes == '12') {
        return 'dezembro';
    }
}

?>
    