<?php

define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
require_once("../dompdf/dompdf_config.inc.php");

$html = '<div id="content"><br></br>
            <table width="100%" border="0">
                <tr>
                    <td align="center">
                        <a id="voltarSistema" class="botao_superior" href="../../../intermed.php">Selecionar outro Sistema</a>
                    </td>
                </tr>
                <tr>
                    <td><h1 align="center">Gerenciar Registros</h1></td>
                </tr></table>';


$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper('letter', 'landscape');
$dompdf->render();
$options = array(
    'Attachment' => 0    
);
$dompdf->stream("exemplo-01.pdf", $options);
?>