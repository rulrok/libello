<?php

include APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/Imagem.php";
require_once APP_LOCATION . "modelo/validadorCPF.php";
include APP_LOCATION . "visao/verificadorFormularioAjax.php";

class verificarnovaimagem extends verificadorFormularioAjax {

    public function _validar() {
        define("MAX_SIZE", "2000");
        define("LARGURA_THUMB", "350");
        define("ALTURA_THUMB", "150");
        $formatosPermitidosImagens = array("jpg", "jpeg", "png");
        $formatosPermitidosVetoriais = array("svg", "cdr");
        $galerias_dir = APP_PRIVATE_DIR . "galerias";

        $tamanhoMaximo = filter_input(INPUT_POST, 'MAX_FILE_SIZE');
        $arquivoImagem = "image-upload";
        $arquivoVetorial = "raw-image-upload";

        if (!empty($_FILES[$arquivoImagem]['error']) || !empty($_FILES[$arquivoVetorial]['error'])) {
            $origemErro = (!empty($_FILES[$arquivoImagem]['error'])) ? $arquivoImagem : $arquivoVetorial;
            $this->processarErroImagem($_FILES[$origemErro]['error'], $_FILES[$origemErro]['name']);
        } elseif (empty($_FILES[$arquivoImagem]['tmp_name']) || $_FILES[$arquivoImagem]['tmp_name'] == 'none') {
            $this->mensagemErro("Arquivo da imagem não pôde ser enviado.");
        } elseif (empty($_FILES[$arquivoVetorial]['tmp_name']) || $_FILES[$arquivoVetorial]['tmp_name'] == 'none') {
            $this->mensagemErro("Arquivo vetorizado não pôde ser enviado.");
        } else {

            $titulo = filter_input(INPUT_POST, 'titulo');
            $ano = filter_input(INPUT_POST, 'ano');
            $cpfAutor = validadorCPF::normalizarCPF(obterUsuarioSessao()->get_cpf());
//            $cpfAutor = filter_input(INPUT_POST, 'cpfautor');
//            if (!validadorCPF::validarCPF($cpfAutor)) {
//                $cpfAutor = obterUsuarioSessao()->get_cpf();
//                if (!validadorCPF::validarCPF($cpfAutor)) {
//                    $this->mensagemErro("CPF Inválido");
//                }
//            }
//            $cpfAutor = validadorCPF::normalizarCPF($cpfAutor);

            $iniciais = obterUsuarioSessao()->get_iniciais();

            $observacoes = filter_input(INPUT_POST, 'observacoes');
            $descritor1 = fnDecrypt(filter_input(INPUT_POST, 'descritor1'));
            $descritor2 = fnDecrypt(filter_input(INPUT_POST, 'descritor2'));
            $descritor3 = fnDecrypt(filter_input(INPUT_POST, 'descritor3'));
            $descritor4 = fnDecrypt(filter_input(INPUT_POST, 'descritor4'));
//            $categoria = fnDecrypt(filter_input(INPUT_POST, 'categoria'));
//            $subcategoria = fnDecrypt(filter_input(INPUT_POST, 'subcategoria'));
//            $dificuldade = fnDecrypt(filter_input(INPUT_POST, 'complexidade'));
            $dificuldade = filter_input(INPUT_POST, 'complexidade');

            $nomeImagem = $_FILES[$arquivoImagem]['name'];
            //OBS $_FILES[arq]['type'] não verifica o tipo do arquivo pelo seu cabeçalho, apenas pela extensão, então extrair a extensão pelo o nome ou pelo
            //parâmetro 'type' tem o mesmo efeito. Esperava mais de você PHP :/

            $tipoImagem = strtolower($this->getExtension($nomeImagem));


            if (!in_array($tipoImagem, $formatosPermitidosImagens)) {
                $this->mensagemErro("Tipo de imagem inválido.<br/>Utilize apenas arquivos jpg/jpeg ou png.");
            }

            $nomeImagemVetorial = $_FILES[$arquivoVetorial]['name'];
            $tipoImagemVetorial = strtolower($this->getExtension($nomeImagemVetorial));

            //TODO Verificar quais serão os tipos válidos
            if (!in_array($tipoImagemVetorial, $formatosPermitidosVetoriais)) {
                $this->mensagemErro("Arquivo vetorial inválido.");
            }

            $tamanhoImagem = filesize($_FILES[$arquivoImagem]['tmp_name']);
            if ($tamanhoImagem > MAX_SIZE * 1024) {
                $this->mensagemErro("Tamanho máximo permitido para a imagem: " . ($tamanhoMaximo / 1024) . " Kb.");
            }

            $imagensDAO = new imagensDAO();
            $codigo_desc_1 = $imagensDAO->consultarDescritor('rotulo', 'idDescritor = ' . $descritor1)[0][0];
            $codigo_desc_2 = $imagensDAO->consultarDescritor('rotulo', 'idDescritor = ' . $descritor2)[0][0];
            $codigo_desc_3 = $imagensDAO->consultarDescritor('rotulo', 'idDescritor = ' . $descritor3)[0][0];
            $codigo_desc_4 = $imagensDAO->consultarDescritor('rotulo', 'idDescritor = ' . $descritor4)[0][0];
//            $dimensoesImagem = getimagesize($_FILES[$arquivoImagem]['tmp_img']);
            $nomeFinalArquivoImagem = $this->montarNome(array($codigo_desc_1, $codigo_desc_2, $codigo_desc_3, $codigo_desc_4, $dificuldade, $iniciais));

            $timestamp = time();

            if (!file_exists($galerias_dir . "/$cpfAutor/")) {
                mkdir($galerias_dir . "/$cpfAutor/");
            }

            $destinoImagem = $galerias_dir . "/$cpfAutor/" . $nomeFinalArquivoImagem . "_$timestamp." . $tipoImagem;

            $imagemCopiada = copy($_FILES[$arquivoImagem]['tmp_name'], $destinoImagem);

            if (!$imagemCopiada) {
                $this->mensagemErro("Erro ao mover imagem para a pasta do servidor<br/>" . print_r($imagemCopiada, true));
            }


            $destinoImagemVetorial = $galerias_dir . "/$cpfAutor/" . $nomeFinalArquivoImagem . "_vetorial_$timestamp." . $tipoImagemVetorial;

            $imagemVetorialCopiada = copy($_FILES[$arquivoVetorial]['tmp_name'], $destinoImagemVetorial);
            if (!$imagemVetorialCopiada) {
                $this->mensagemErro("Erro ao mover arquivo vetorial para a pasta do servidor<br/>" . print_r($imagemVetorialCopiada, true));
            }

            if (!file_exists($galerias_dir . "/miniaturas/$cpfAutor/")) {
                mkdir($galerias_dir . "/miniaturas/$cpfAutor/");
            }
            $destinoImagemMiniatura = $galerias_dir . "/miniaturas/$cpfAutor/" . $nomeFinalArquivoImagem . "_thumb_$timestamp." . $tipoImagem;
            $this->make_thumb($destinoImagem, $destinoImagemMiniatura, LARGURA_THUMB, ALTURA_THUMB);

            if (!file_exists($destinoImagem)) {
                $this->mensagemErro("Erro ao criar a miniatura para a imagem<br/>" . print_r($destinoImagem, true));
            }
            $imagemVO = new Imagem();


            $idGaleria = $imagensDAO->consultarGaleria($cpfAutor)[0][0];
            if (empty($idGaleria)) {
                if (!$imagensDAO->cadastrarGaleria($cpfAutor)) {
                    $this->mensagemErro("Problema ao criar galeria");
                } else {
                    $idGaleria = $imagensDAO->consultarGaleria($cpfAutor);
                }
            }
//            $idGaleria = $idGaleria[0][0];
            $imagemVO->set_idGaleria($idGaleria)->set_descritor1($descritor1)->set_descritor2($descritor2)->set_descritor3($descritor3)->set_descritor4($descritor4);

            $imagemVO->set_titulo($titulo)->set_observacoes($observacoes)->set_dificuldade($dificuldade);
            $imagemVO->set_cpfAutor($cpfAutor)->set_ano($ano);

            $imagemVO->set_utilizadoAvaliacao(0)->set_avaliacao(null)->set_anoAvaliacao(null);

//            $imagemVO->set_nomeArquivo($nomeFinalArquivoImagem . "." . $tipoImagem)->set_nomeArquivoMiniatura($nomeFinalArquivoImagem . "-thumb." . $tipoImagem);
//            $imagemVO->set_nomeArquivoVetorial($nomeFinalArquivoImagem . "-vetorial." . $tipoImagemVetorial);
            $imagemVO->set_nomeArquivo($destinoImagem)->set_nomeArquivoMiniatura($destinoImagemMiniatura);
            $imagemVO->set_nomeArquivoVetorial($destinoImagemVetorial);

            try {
                if ($imagensDAO->cadastrarImagem($imagemVO)) {
                    //TODO recuperar o ID da imagem
//                    imagensDAO::registrarCadastroImagem($idImagem);
                    $this->mensagemSucesso("Imagem cadastrada.");
                }
            } catch (Exception $ex) {
                $this->mensagemErro($ex->getMessage());
            }
        }
    }

    function processarErroImagem($erro, $arquivo) {
        switch ($erro) {
            case '1':
//                    $error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                $this->mensagemErro("Arquivo muito grande para o servidor!<br/>Tente um arquivo menor.");
            case '2':
//                    $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                $this->mensagemErro("Tamanho da imagem inválido.");
            case '3':
//                    $error = 'The uploaded file was only partially uploaded';
                $this->mensagemErro("O arquivo $arquivo não pode ser carregado completamente.<br/>Tente novamente.");
            case '4':
//                    $error = 'No file was uploaded.';
                $this->mensagemErro("Nenhum arquivo foi selecionado.");
            case '6':
//                    $error = 'Missing a temporary folder';
                $this->mensagemErro("Erro ao salvar o arquivo no servidor.");
            case '7':
//                    $error = 'Failed to write file to disk';
                $this->mensagemErro("Erro ao salvar o arquivo no servidor.");
            case '8':
//                    $error = 'File upload stopped by extension';
                $this->mensagemErro("Operação interrompida pelo servidor.");
            default:
//                    $error = 'No error code avaiable';
                $this->mensagemErro("Erro desconhecido.");
        }
    }

    function montarNome($nomes, $separador = '-') {
        if (!is_array($nomes)) {
            return $nomes;
        } else {
            $ret = "";
            foreach ($nomes as $nome) {
                $ret .= $nome . $separador;
            }
            $ret = preg_replace("/-$/", "", $ret);
            return $ret;
        }
    }

    function make_thumb($img_name, $filename, $new_w, $new_h) {
        //get image extension.
        $ext = $this->getExtension($img_name);
        //creates the new image using the appropriate function from gd library
        if (!strcmp("jpg", $ext) || !strcmp("jpeg", $ext))
            $src_img = imagecreatefromjpeg($img_name);

        if (!strcmp("png", $ext))
            $src_img = imagecreatefrompng($img_name);

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

// This function reads the extension of the file.
// It is used to determine if the file is an image by checking the extension.
    function getExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

}

$verificar = new verificarnovaimagem();
$verificar->verificar();
?>