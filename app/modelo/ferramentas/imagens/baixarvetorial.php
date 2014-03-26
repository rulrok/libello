<?php

ob_clean();
if (filter_has_var(INPUT_GET, 'idImagem')) {
    try {
        $idImagem = fnDecrypt(filter_input(INPUT_GET, 'idImagem'));
        $imagensDAO = new imagensDAO();
        $imagem = $imagensDAO->consultarImagem($idImagem);
        $nomeArquivo = $imagem->get_nomeArquivoVetorial();
        $diretorio = $imagem->get_diretorio();
        $nomeArquivoNormalizado = preg_filter("#_.*?\.#", '.', $nomeArquivo);

        if (preg_match('#\.jpe?g$#', $nomeArquivoNormalizado)) {
            $tipoImagem = 'jpg';
        } elseif (preg_match('#\.png$#', $nomeArquivoNormalizado)) {
            $tipoImagem = 'png';
        }


        header("Content-disposition: attachment; filename=$nomeArquivoNormalizado");
        header("Content-type: image/$tipoImagem");
        readfile($diretorio . $nomeArquivo);
    } catch (Exception $e) {
        header("Charset: UTF-8");
        echo "Erro ao processar o arquivo";
    }
}
