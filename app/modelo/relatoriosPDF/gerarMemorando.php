<?php

define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
//incluindo o arquivo do fpdf
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/Configurations.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/dompdf/dompdf_config.inc.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/app/controlador/ControladorDocumentos.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/controle-cead/biblioteca/seguranca/seguranca.php");

//-------------------
//definindo variaveis
$idUsuario = $_SESSION['idUsuario'];
$numMemorando = $_POST['i_numMemorando'];
$tipoSigla = $_POST['sigla'];
$dia = $_POST['dia'];
$mes = $_POST['mes'];
$ano = date('Y');
$data = $dia . '/' . $mes . '/' . date('Y');
$tratamento = $_POST['tratamento'];
$cargo_destino = $_POST['cargo_destino'];
$assunto = $_POST['assunto'];
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
//salvando ou atualizando oficio no banco
$booledit = $_GET['booledit'];
$controlador = new ControladorDocumentos();
if ($booledit == '1') {
    $idmemorando = $_POST['i_idmemorando'];
    $controlador->atualizarMemorando($idmemorando, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao);
} else {
    $controlador->novoMemorando($idUsuario, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao);
}

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
                        <img src="../../../publico/images/oficio/cabecalho.jpg"></img>
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
?>
    
