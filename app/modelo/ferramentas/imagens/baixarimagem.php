<?php

namespace app\modelo\ferramentas\imagens;

require_once APP_DIR . "modelo/PaginaDeAcao.php";

use \app\modelo as Modelo;

class baixarimagem extends \app\modelo\PaginaDeAcao {

    public function _acaoPadrao() {
        $this->omitirMensagens();
        ob_clean();
        if (filter_has_var(INPUT_GET, 'idImagem')) {
            try {
                $idImagem = fnDecrypt(filter_input(INPUT_GET, 'idImagem'));
                $imagensDAO = new Modelo\imagensDAO();
                $imagem = $imagensDAO->consultarImagem($idImagem);
                $nomeArquivo = $imagem->get_nomeArquivo();
                $diretorio = $imagem->get_diretorio();
                $nomeArquivoNormalizado = preg_filter("#_.*?\.#", '.', $nomeArquivo);

                if (preg_match('#\.jpe?g$#', $nomeArquivoNormalizado)) {
                    $tipoImagem = 'jpg';
                } elseif (preg_match('#\.png$#', $nomeArquivoNormalizado)) {
                    $tipoImagem = 'png';
                }

                header("X-Robots-Tag: noindex, nofollow", true);
                header("Content-disposition: attachment; filename=$nomeArquivoNormalizado");
                header("Content-type: image/$tipoImagem");
                readfile($diretorio . $nomeArquivo);
            } catch (\Exception $e) {
                header("Charset: UTF-8");
                echo "Erro ao processar o arquivo";
            }
        }
    }

}
