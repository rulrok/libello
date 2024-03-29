<?php

namespace app\modelo\ferramentas\documentos;

//incluindo o arquivo do fpdf
require_once APP_LIBRARY_DIR . "configuracoes.php";
require_once APP_LIBRARY_DIR . "dompdf/dompdf_config.inc.php";
require_once APP_LIBRARY_DIR . "seguranca/seguranca.php";
require_once APP_LIBRARY_DIR . "seguranca/criptografia.php";
require_once APP_DIR . "modelo/dao/documentoDAO.php";

use \app\modelo as Modelo;

class visualizaroficio extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $this->omitirMensagens();
        ob_clean();
        header('Content-Type: text/plain; charset=UTF-8');
        //-------------------
        //definindo variaveis
        $id = fnDecrypt($_REQUEST['idv']);
        $oficio = (new Modelo\documentoDAO())->consultar('documento_oficio', 'idOficio = ' . $id);
        $numOficio = $oficio[0]->get_numOficio();
        $tipoSigla = $oficio[0]->get_tipoSigla();
        $data = explode('/', $oficio[0]->get_data());
        $dia = $data[0];
        $ano = $data[2];
        $tratamento = $oficio[0]->get_tratamento();
        $destino = $oficio[0]->get_destino();
        $cargo_destino = $oficio[0]->get_cargo_destino();
        $assunto = $oficio[0]->get_assunto();
        $referencia = $oficio[0]->get_referencia();
        $corpo = $oficio[0]->get_corpo();
        $remetente = $oficio[0]->get_remetente();
        $cargo_remetente = $oficio[0]->get_cargo_remetente();

        $remetentes = explode(';', $remetente);
        $cargos_remetentes = explode(';', $cargo_remetente);

        setlocale(LC_ALL, 'portuguese-brazilian', 'ptb', 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'pt-BR');
        $mes = (strftime("%B", mktime(0, 0, 0, $data[1], 10)));
        $data = $dia . '/' . $mes . '/' . $ano;

        //-------------------
        $document = '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">   



        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
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
        </head>
        <body>
      <script type="text/php">

       if ( isset($pdf) ) {

         $font = Font_Metrics::get_font("helvetica", "bold");
         $w = $pdf->get_width();
         $h = $pdf->get_height();
         $pdf->page_text($w-72, $h-30, utf8_encode("Página {PAGE_NUM}/{PAGE_COUNT}"), $font, 8, array(0,0,0));

       }
       </script>
            <table class="tabela">
                <tr>
                    <td style="width: 597px" align="center">
                        <img src="publico/imagens/cabecalho-documentos/cabecalho.jpg"></img>
                    </td>
                </tr>
                <tr><td style="height: 30px;"></td></tr>
                <tr>
                    <td>
                        Ofício nº' . $numOficio . '/CEAD - ' . $tipoSigla . '
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
                        ' . $corpo . '
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
                       ';
        for ($i = 0; $i < count($remetentes); $i++) {
            $document.= '<div >
                            <table align="center">
                                <tr>
                                    <td style="height: 20px;">
                                        <span>____________________________________</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="height: 20px;">
                                        <span>' . $remetentes[$i] . '</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="height: 20px;">
                                        <span> ' . $cargos_remetentes[$i] . ' </span>
                                    </td>                                                    
                                </tr>
                            </table>
                        </div><br>';
        }
        $document .= '</table>
  
        </body>
    </html>';
        //echo $document;
        //echo $document; die();
        $dompdf = new \DOMPDF();
        //$tamanho = array(0, 0, 596.4, 843.48);
        $dompdf->parse_default_view('A4', 'portrait');
        $dompdf->set_paper('A4', 'portrait');
        $dompdf->load_html($document);
        $dompdf->render();
        //$dompdf->;
        $options = array(
            'Attachment' => 0
        );
        $dompdf->stream($ano . " - Oficio n" . $numOficio, $options);
    }

}
?>
    
