<?php

namespace app\modelo\ferramentas\imagens;

require_once APP_DIR . "modelo/PaginaDeAcao.php";

use \app\modelo as Modelo;

class visualizarimagem extends \app\modelo\PaginaDeAcao {

    public function _acaoPadrao() {
        if (filter_has_var(INPUT_GET, 'id')) {
            $id = fnDecrypt(filter_input(INPUT_GET, 'id'));
            $imagensDAO = new Modelo\imagensDAO();
            $imagem = $imagensDAO->consultarImagem($id);
            $arqImagem = ROOT . $imagem->get_diretorio() . $imagem->get_nomeArquivo();
            $extensao = obterExtensaoArquivo($imagem->get_nomeArquivo());

            $this->omitirMensagens();
            ob_clean();
//    ob_start();
            header("Content-Type: image/$extensao");
            header('Content-Length: ' . filesize($arqImagem));
//    header("Content-Disposition: inline; filename='abc.$extensao'");
            readfile($arqImagem);
//            passthru("cat $arqImagem");
//    ob_end_flush();
//    ob_start();
//    header("Content-Type: image/$extensao");
////    header("Content-Transfer-Encoding: BASE64");
//    if ($extensao == "png") {
//        $imagemres = imagecreatefrompng($arqImagem);
//        imagepng($imagemres);
//    } else {
//        $imagemres = imagecreatefromjpeg($arqImagem);
//        imagejpeg($imagemres);
//    }
////    $imagemBase64 = base64_encode(ob_get_contents());
//    imagedestroy($imagemres);
//    ob_end_flush();
//
////    echo "<img src='data:image/png;base64,$imagemBase64'>";
        }
    }

}
