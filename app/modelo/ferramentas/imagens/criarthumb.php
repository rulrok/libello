<?php

namespace app\modelo\ferramentas\imagens;

/*
 * Arquivo utilizado para gerar a visualização de imagem para quando o usuário escolhe
 * uma imagem para ser enviada na página de cadastro de imagens.
 * Possui dois métodos em comum com o arquivo 'verificarnovaimagem.php' que talvez
 * possam ser todos movidos para uma classe em comum.
 * Este arquivo tem apenas a finalidade descrita acima.
 */


require_once APP_DIR . 'modelo/Utils.php';

use \app\modelo as Modelo;

class criarthumb extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
//        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['imagemURI'])) {

        define("WIDTH", "350");
        define("HEIGHT", "150");

        $aux = preg_split("/,/", filter_input(INPUT_POST, 'imagemURI'));
        $infos = $aux[0];
        $imagem64 = $aux[1];

        //reads the name of the file the user submitted for uploading
        $image = imagecreatefromstring(base64_decode($imagem64));

        // if it is not empty
        if ($image) {

            $image_name = time() . obterUsuarioSessao()->get_idUsuario();
            //TODO Mover esse tipo de comando para um arquivo de intalação
            if (!file_exists(APP_TEMP_DIR . 'masters/')) {
                mkdir(APP_TEMP_DIR . 'masters/');
            }
            if (!file_exists(APP_TEMP_DIR . 'thumbs/')) {
                mkdir(APP_TEMP_DIR . 'thumbs/');
            }
            if (preg_match("$.*/jpe?g;$", $infos)) {
                $extension = "jpeg";
                $master_name = APP_TEMP_DIR . 'masters/' . $image_name . '.' . $extension;
                imagejpeg($image, $master_name);
            } elseif (preg_match("$.*/png;$", $infos)) {
                $extension = "png";
                $master_name = APP_TEMP_DIR . 'masters/' . $image_name . '.' . $extension;
                imagepng($image, $master_name);
            } else {
//                    die("Tipo não suportado");
                $this->adicionarMensagemErro("Tipo não suportado");
                $this->abortarExecucao();
            }

            $thumb_name = APP_TEMP_DIR . 'thumbs/' . $image_name . '_350.' . $extension;

            $thumb = $this->make_thumb($master_name, $thumb_name, WIDTH, HEIGHT);

            //image dimensions
            $masterWH = getimagesize($master_name);
            $masterW = $masterWH[0];
            $masterH = $masterWH[1];
            $thumbWH = getimagesize($thumb_name);
            $thumbW = $thumbWH[0];
            $thumbH = $thumbWH[1];


            $ret = array(
                "master" => array(
                    "img_src" => str_replace("../", "", $master_name),
                    "size" => round((filesize($master_name) / 1024), 0) . 'kb',
                    'h' => $masterH,
                    'w' => $masterW
                ),
                "thumb" => array(
                    "img_src" => str_replace("../", "", $thumb_name), //tweak return path of img
                    "size" => round((filesize($thumb_name) / 1024), 0) . 'kb',
                    'h' => $thumbH,
                    'w' => $thumbW
                )
            );
            $this->adicionarMensagemPersonalizada("img_resultados", json_encode($ret));
        } else {
            $this->adicionarMensagemErro("Falha ao receber imagem");
        }

//        }
    }

    function make_thumb($img_name, $filename, $new_w, $new_h) {
        //get image extension.
        $ext = obterExtensaoArquivo($img_name);
        //creates the new image using the appropriate function from gd library
        if (!strcmp("jpg", $ext) || !strcmp("jpeg", $ext)) {
            $src_img = imagecreatefromjpeg($img_name);
        } elseif (!strcmp("png", $ext)) {
            $src_img = imagecreatefrompng($img_name);
        }

        //gets the dimmensions of the image
        $old_x = imageSX($src_img);
        $old_y = imageSY($src_img);

        // next we will calculate the new dimmensions for the thumbnail image
        // the next steps will be taken:
        //  1. calculate the ratio by dividing the old dimmensions with the new ones
        //  2. if the ratio for the width is higher, the width will remain the one define in WIDTH variable
        //      and the height will be calculated so the image ratio will not change
        //  3. otherwise we will use the height ratio for the image
        // as a result, only one of the dimmensions will be from the fixed ones
        $ratio1 = $old_x / $new_w;
        $ratio2 = $old_y / $new_h;
        if ($ratio1 > $ratio2) {
            $thumb_w = $new_w;
            $thumb_h = $old_y / $ratio1;
        } else {
            $thumb_h = $new_h;
            $thumb_w = $old_x / $ratio2;
        }

        // we create a new image with the new dimmensions
        $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);

        // resize the big image to the new created one
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);

        // output the created image to the file. Now we will have the thumbnail into the file named by $filename
        if (!strcmp("png", $ext))
            imagepng($dst_img, $filename);
        else
            imagejpeg($dst_img, $filename);

        //destroys source and destination images.
        imagedestroy($dst_img);
        imagedestroy($src_img);
    }

}

?>