<?php
ob_clean();
if (filter_has_var(INPUT_GET, 'idImagem')) {
    $idImagem = fnDecrypt(filter_input(INPUT_GET, 'idImagem'));
    $imagensDAO = new imagensDAO();
    $imagem = $imagensDAO->consultarImagem($idImagem);
    $enderecoArquivo = $imagem->get_nomeArquivoVetorial();
    $nomeArquivo = preg_filter("#.*?/#", '', $enderecoArquivo);
    $nomeArquivoNormalizado = preg_filter("#_.*\.#", '.', $nomeArquivo);

    if (preg_match('#\.jpe?g$#', $nomeArquivoNormalizado)){
        $tipoImagem = 'jpg';
    } elseif (preg_match('#\.png$#', $nomeArquivoNormalizado)){
        $tipoImagem = 'png';
    }
    
    $diretorioTemp = APP_TEMP_DIR . time();
    mkdir($diretorioTemp);
    $arquivoTemp = $diretorioTemp . '/' . $nomeArquivoNormalizado;
    $copiou = copy($enderecoArquivo, $arquivoTemp);

    if (!$copiou) {
        echo 'Erro ao baixar imagem';
        die('Erro ao copiar');
    }

    header("Content-disposition: attachment; filename=$nomeArquivoNormalizado");
    header("Content-type: image/$tipoImagem");
    readfile($arquivoTemp);
}
