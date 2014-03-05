<?php

ob_clean();
//incluindo o arquivo do fpdf
require_once BIBLIOTECA_DIR . "configuracoes.php";
require_once BIBLIOTECA_DIR . "dompdf/dompdf_config.inc.php";
require_once BIBLIOTECA_DIR . "seguranca/seguranca.php";
require_once BIBLIOTECA_DIR . "seguranca/criptografia.php";
require_once APP_DIR . "modelo/dao/documentoDAO.php";

//-------------------
//definindo variaveis
$id = fnDecrypt($_REQUEST['idv']);
$memorando = (new documentoDAO())->consultar('memorando', 'idMemorando = ' . $id);
$numMemorando = $memorando[0]->getNumMemorando();
$tipoSigla = $memorando[0]->getTipoSigla();
$data = explode('/', $memorando[0]->getData());
$dia = $data[0];
$mes = $data[1];
$ano = $data[2];
$tratamento = $memorando[0]->getTratamento();
$cargo_destino = $memorando[0]->getCargo_destino();
$assunto = $memorando[0]->getAssunto();
$corpo = $memorando[0]->getCorpo();
$remetente = $memorando[0]->getRemetente();
$cargo_remetente = $memorando[0]->getCargo_remetente();
$remetente2 = $memorando[0]->getRemetente2();
$cargo_remetente2 = $memorando[0]->getCargo_remetente2();

if ($remetente2 != '' && $cargo_remetente2 != '') {
    $i_remetente = '1';
} else {
    $i_remetente = '0';
}

//$mes = retornaMes($mes);
setlocale(LC_ALL, 'portuguese-brazilian', 'ptb', 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8');
$mes = $monthName = date("F", mktime(0, 0, 0, $mes, 10));
$data = $dia . '/' . $mes . '/' . date('Y');
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
                       <img src="publico/imagens/oficio/cabecalho.jpg"></img>
                    </td>
                </tr>
                <tr><td style="height: 30px;"></td></tr>
                <tr>
                    <td>
                        Mem. nº' . $numMemorando . '/' . $ano . '/CEAD - ' . $tipoSigla . '
                    </td>
                </tr>
                <tr><td style="height: 40px;"></td></tr>
                <tr >
                    <td align="right">
                        Alfenas, ' . $dia . ' de ' . $mes . ' de ' . $ano . '
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
$dompdf->stream($ano . " - Memorando n" . $numMemorando, $options);

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
    
