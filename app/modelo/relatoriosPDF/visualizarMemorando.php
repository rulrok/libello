<?php

define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
//incluindo o arquivo do fpdf
require_once("../dompdf/dompdf_config.inc.php");
require_once '../../documentos/controller/ControllerDoc.php';
require_once '../seguranca.php';

//-------------------
//definindo variaveis
$id = $_GET['id'];
$memorando = mysql_fetch_array(getMemorando($id));
$numMemorando = $memorando["numMemorando"];
$tipoSigla = $memorando["tipoSigla"];
$data = explode('/', $memorando["data"]);
$dia = $data[0];
$mes = $data[1];
$ano = $data[2];
$tratamento = $memorando["tratamento"];
$cargo_destino = $memorando["cargo_destino"];
$assunto = $memorando["assunto"];
$corpo = $memorando["corpo"];
$remetente = $memorando["remetente"];
$cargo_remetente = $memorando["cargo_remetente"];
$remetente2 = $memorando["remetente2"];
$cargo_remetente2 = $memorando["cargo_remetente2"];

if($remetente2 != '' && $cargo_remetente2 != ''){
    $i_remetente = '1';
}
else{
    $i_remetente = '0';
}

//$mes = retornaMes($mes);
$data = $dia . '/' . $mes . '/' . $ano;
//-------------------
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
                    <td style="width: 580px" align="center">
                        <img src="../images/cabecalho.jpg"></img>
                    </td>
                </tr>
                <tr><td style="height: 30px;"></td></tr>
                <tr>
                    <td>
                        Mem. nº'.$numMemorando.'/'.$ano.'/CEAD - ' . $tipoSigla . '
                    </td>
                </tr>
                <tr><td style="height: 40px;"></td></tr>
                <tr >
                    <td align="right">
                        Alfenas ' . $dia . ' de ' . $mes . ' de ' . date("Y") . '
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
                        <div align="center">
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
                <tr><td style="height: 112px;"></td></tr>
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
$dompdf->stream($ano." - Memorando n".$numMemorando, $options);

function retornaMes($mes) {
    if ($mes == '01'){        
        return 'janeiro';
    }
    if ($mes == '02'){        
        return 'fevereiro';
    }
    if ($mes == '03'){        
        return 'março';
    }
    if ($mes == '04'){        
        return 'abril';
    }
    if ($mes == '05'){        
        return 'maio';
    }
    if ($mes == '06'){        
        return 'junho';
    }
    if ($mes == '07'){        
        return 'julho';
    }
    if ($mes == '08'){        
        return 'agosto';
    }
    if ($mes == '09'){        
        return 'setembro';
    }
    if ($mes == '10'){        
        return 'outubro';
    }
    if ($mes == '11'){        
        return 'novembro';
    }
    if ($mes == '12'){        
        return 'dezembro';
    }        
}

?>
    