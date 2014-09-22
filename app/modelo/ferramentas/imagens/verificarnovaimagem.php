<?php

namespace app\modelo\ferramentas\imagens;

require_once APP_DIR . "modelo/Mensagem.php";
require_once APP_DIR . "modelo/Utils.php";
require_once APP_DIR . "modelo/vo/Imagem.php";
require_once APP_DIR . "modelo/validadorCPF.php";
include APP_DIR . "modelo/verificadorFormularioAjax.php";

use \app\modelo as Modelo;

/**
 * Verifica se o formulário de cadastro de imagem e seus dados estão todos corretos
 * para poder registrar a nova imagem na base de dados.
 */
class verificarnovaimagem extends Modelo\verificadorFormularioAjax {

    private function _auxiliar_ultimo_id_inserido(Modelo\imagensDAO $dao, $nomeDescritor) {
        $resultado = $dao->consultarDescritor("idDescritor", "nome = '$nomeDescritor' ORDER BY idDescritor DESC LIMIT 1");
        return $resultado[0][0];
    }

    public function _validar() {
        /*
         * Definimos algumas configurações que serão usadas ao longo de script
         */

        define("LARGURA_THUMB", "350");
        define("ALTURA_THUMB", "150");
        $formatosPermitidosImagens = array("jpg", "jpeg", "png");
        $formatosPermitidosVetoriais = array("svg", "cdr", "fh", "ai", "wmd", "dwg", "dwf", "3ds", "xcf");
        $galerias_dir = APP_GALLERY_DIR;

        $tamanhoMaximo = filter_input(INPUT_POST, 'MAX_FILE_SIZE');
        $arquivoImagem = "image-upload";
        $arquivoVetorial = "raw-image-upload";

        if (!empty($_FILES[$arquivoImagem]['error']) || !empty($_FILES[$arquivoVetorial]['error'])) {
            $origemErro = (!empty($_FILES[$arquivoImagem]['error'])) ? $arquivoImagem : $arquivoVetorial;
            $this->processarErroImagem($_FILES[$origemErro]['error'], $_FILES[$origemErro]['name']);
        } elseif (empty($_FILES[$arquivoImagem]['tmp_name']) || $_FILES[$arquivoImagem]['tmp_name'] == 'none') {
            $this->adicionarMensagemErro("Arquivo da imagem não pôde ser enviado.");
            $this->abortarExecucao();
        } elseif (empty($_FILES[$arquivoVetorial]['tmp_name']) || $_FILES[$arquivoVetorial]['tmp_name'] == 'none') {
            $this->adicionarMensagemErro("Arquivo vetorizado não pôde ser enviado.");
            $this->abortarExecucao();
        } else {

            //Campos do formulário obtidos diretamente do sistema
            $cpfAutor = Modelo\validadorCPF::normalizarCPF(obterUsuarioSessao()->get_cpf());
            $iniciais = obterUsuarioSessao()->get_iniciais();
            $idAutor = obterUsuarioSessao()->get_idUsuario();

            /*
             * Verificação dos diretórios do sistema
             */

            if (!file_exists(APP_GALLERY_ABSOLUTE_DIR)) {
                if (!mkdir(APP_GALLERY_ABSOLUTE_DIR)) {
                    $this->adicionarMensagemErro("Falha ao configurar o diretório de imagens.<br/>Contate o suporte informando o erro.");
                    $this->abortarExecucao();
                }
            }

            if (!file_exists(APP_GALLERY_ABSOLUTE_DIR . "$cpfAutor/")) {
                mkdir(APP_GALLERY_ABSOLUTE_DIR . "$cpfAutor/");
            }

            $dirMiniaturas = APP_GALLERY_ABSOLUTE_DIR . "miniaturas/";
            if (!file_exists($dirMiniaturas)) {
                if (!mkdir($dirMiniaturas)) {
                    $this->adicionarMensagemErro("Falha ao configurar o diretório de miniaturas.<br/>Contate o suporte informando o erro.");
                    $this->abortarExecucao();
                }
            }
            $dirMiniaturaAutor = APP_GALLERY_ABSOLUTE_DIR . "miniaturas/$cpfAutor/";
            if (!file_exists($dirMiniaturaAutor)) {
                mkdir($dirMiniaturaAutor);
            }


            /*
             * Obtenção dos dados do formulário
             */

            $titulo = filter_input(INPUT_POST, 'titulo');
            $ano = filter_input(INPUT_POST, 'ano');
            $observacoes = filter_input(INPUT_POST, 'observacoes');

            $dificuldade = filter_input(INPUT_POST, 'complexidade');

            $nomeImagem = $_FILES[$arquivoImagem]['name'];
            //OBS $_FILES[arq]['type'] não verifica o tipo do arquivo pelo seu cabeçalho, apenas pela extensão, então extrair a extensão pelo o nome ou pelo
            //parâmetro 'type' tem o mesmo efeito. Esperava mais de você PHP :/

            $tipoImagem = strtolower(obterExtensaoArquivo($nomeImagem));


            if (!in_array($tipoImagem, $formatosPermitidosImagens)) {
                $this->adicionarMensagemErro("Tipo de imagem inválido.<br/>Utilize apenas arquivos jpg/jpeg ou png.");
                $this->abortarExecucao();
            }

            $nomeImagemVetorial = $_FILES[$arquivoVetorial]['name'];
            $tipoImagemVetorial = strtolower(obterExtensaoArquivo($nomeImagemVetorial));

            //TODO Verificar quais serão os tipos válidos
            if (!in_array($tipoImagemVetorial, $formatosPermitidosVetoriais)) {
                $this->adicionarMensagemErro("Arquivo vetorial não permitido.");
                $this->abortarExecucao();
            }

            $tamanhoImagem = filesize($_FILES[$arquivoImagem]['tmp_name']);
            if ($tamanhoImagem > APP_MAX_UPLOAD_SIZE) {
                $this->adicionarMensagemErro("Tamanho máximo permitido para a imagem: " . ($tamanhoMaximo / 1024) . " Kb.");
                $this->abortarExecucao();
            }

            $descritor1 = fnDecrypt(filter_input(INPUT_POST, 'descritor1'));
            $descritor2 = fnDecrypt(filter_input(INPUT_POST, 'descritor2'));
            $descritor3 = fnDecrypt(filter_input(INPUT_POST, 'descritor3'));

            $imagensDAO = new Modelo\imagensDAO();

            //Verifica a galeria do usuário no banco
            $idGaleria = $imagensDAO->consultarGaleria($cpfAutor)[0][0];
            if (empty($idGaleria)) {
                if (!$imagensDAO->cadastrarGaleria($cpfAutor, $idAutor)) {
                    $this->adicionarMensagemErro("Problema ao criar galeria");
                    $this->abortarExecucao();
                } else {
                    $idGaleria = $imagensDAO->consultarGaleria($cpfAutor);
                }
            }

            //Verifica se um novo descritor está sendo cadastrado ou não
            if (filter_has_var(INPUT_POST, 'descritor_4_personalizado')) {
                $novo_descritor_nome = filter_input(INPUT_POST, 'novo_descritor_4');


                //Verifica se ele já está cadastrado para não tentar uma duplicidade de cadastro
                $params = array(
                    ':pai' => [$descritor3, \PDO::PARAM_INT]
                    , ':nome' => [normalizarNomeDescritor($novo_descritor_nome), \PDO::PARAM_STR]
                );
                $resultado = $imagensDAO->consultarDescritor('idDescritor', 'pai = :pai AND nome = :nome LIMIT 1', null, $params);

                if (sizeof($resultado) === 0) {

                    $novo_descritor = new Descritor();
                    $novo_descritor->set_nome($novo_descritor_nome);
                    if ($imagensDAO->cadastrarDescritor($novo_descritor, $descritor3)) {
                        $descritor4 = $this->_auxiliar_ultimo_id_inserido($imagensDAO, $novo_descritor_nome);
                    } else {
                        $this->adicionarMensagemErro("Não foi possível cadastrar o novo descritor");
                        $this->abortarExecucao();
                    }
                } else {
                    $descritorExistente = $resultado[0];
                    $descritor4 = $descritorExistente['idDescritor'];
                }
            } else {
                $descritor4 = fnDecrypt(filter_input(INPUT_POST, 'descritor4'));
            }

            //Obtém os códigos que irão compor o nome do arquivo de imagem no servidor
            $codigo_desc_1 = $imagensDAO->consultarDescritor('rotulo', 'idDescritor = ' . $descritor1)[0][0];
            $codigo_desc_2 = $imagensDAO->consultarDescritor('rotulo', 'idDescritor = ' . $descritor2)[0][0];
            $codigo_desc_3 = $imagensDAO->consultarDescritor('rotulo', 'idDescritor = ' . $descritor3)[0][0];

            /*
             * Como o quarto descritor agora pode ser cadastrado pelo usuário, dado a sua grande especifidade,
             * o seu código não irá compor mais o nome do arquivo, como era feito antes.
             * 
             */

//            $codigo_desc_4 = $imagensDAO->consultarDescritor('rotulo', 'idDescritor = ' . $descritor4)[0][0];
//            $dimensoesImagem = getimagesize($_FILES[$arquivoImagem]['tmp_img']);

            /*
             * O NOME DO ARQUIVO QUE SERÁ SALVO NO SERVIDOR DEVE SER CONFIGURADO UNICAMENTE NESSA VARIÁVEL
             * ELE SERÁ USADO COMO BASE PARA GERAR OS NOMES DAS THUMBS E ARQUIVO VETORIAL COM SUAIS INFORMAÇÕES ADICIONAIS
             * COMO TIMESTAMP.
             */

            $nomeFinalArquivoImagem = $this->montarNome(array($codigo_desc_1, $codigo_desc_2, $codigo_desc_3, $dificuldade, $iniciais));

            $timestamp = time();
            //--------------    Trata o arquivo original    -------------
            $destinoImagem = $galerias_dir . "$cpfAutor/";
            $nomeArquivo = $nomeFinalArquivoImagem . "_$timestamp." . $tipoImagem;

            $imagemCopiada = copy($_FILES[$arquivoImagem]['tmp_name'], ROOT . $destinoImagem . $nomeArquivo);

            if (!$imagemCopiada) {
                $this->adicionarMensagemErro("Erro ao mover imagem para a pasta do servidor");
                $this->abortarExecucao();
            }

            //--------------    Trata o arquivo vetorial    -------------
            $destinoImagemVetorial = $galerias_dir . "$cpfAutor/";
            $nomeArquivoVetorial = $nomeFinalArquivoImagem . "_vetorial_$timestamp." . $tipoImagemVetorial;

            $imagemVetorialCopiada = copy($_FILES[$arquivoVetorial]['tmp_name'], ROOT . $destinoImagemVetorial . $nomeArquivoVetorial);
            if (!$imagemVetorialCopiada) {
                $this->adicionarMensagemErro("Erro ao mover arquivo vetorial para a pasta do servidor");
                $this->abortarExecucao();
            }

            //--------------    Trata o arquivo de miniatura    -------------
            $destinoImagemMiniatura = $galerias_dir . "miniaturas/$cpfAutor/";
            $nomeArquivoMiniatura = $nomeFinalArquivoImagem . "_thumb_$timestamp." . $tipoImagem;
            $this->make_thumb(ROOT . $destinoImagem . $nomeArquivo, ROOT . $destinoImagemMiniatura . $nomeArquivoMiniatura, LARGURA_THUMB, ALTURA_THUMB);

            if (!file_exists(ROOT . $destinoImagemMiniatura . $nomeArquivoMiniatura)) {
                $this->adicionarMensagemErro("Erro ao criar a miniatura para a imagem");
                $this->abortarExecucao();
            }

            /*
             * Todos os dados e arquivos prontos para serem cadastrados.
             * Preparando a imagem para ser cadastrada.
             */
            $imagemVO = new Modelo\Imagem();

            $imagemVO->set_idGaleria($idGaleria)->set_descritor1($descritor1)->set_descritor2($descritor2)->set_descritor3($descritor3)->set_descritor4($descritor4);

            $imagemVO->set_titulo($titulo)->set_observacoes($observacoes)->set_dificuldade($dificuldade);
            $imagemVO->set_cpfAutor($cpfAutor)->set_ano($ano)->set_autor($idAutor);

            $imagemVO->set_utilizadoAvaliacao(0)->set_avaliacao(null)->set_anoAvaliacao(null);

            $imagemVO->set_diretorio($destinoImagem)->set_diretorioMiniatura($destinoImagemMiniatura);

            $imagemVO->set_nomeArquivo($nomeArquivo)->set_nomeArquivoMiniatura($nomeArquivoMiniatura);
            $imagemVO->set_nomeArquivoVetorial($nomeArquivoVetorial);

            try {
                if ($imagensDAO->cadastrarImagem($imagemVO)) {
                    //TODO recuperar o ID da imagem
//                    imagensDAO::registrarCadastroImagem($idImagem);
                    $this->adicionarMensagemSucesso("Imagem cadastrada.");
                } else {
                    $this->adicionarMensagemErro("Falha ao cadastrar a imagem.");
                    $this->abortarExecucao();
                }
            } catch (\Exception $ex) {
                $this->adicionarMensagemErro($ex->getMessage());
                $this->abortarExecucao();
            }
        }
    }

    function processarErroImagem($erro, $arquivo) {
        switch ($erro) {
            case '1':
//                    $error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                $this->adicionarMensagemErro("Arquivo muito grande para o servidor!<br/>Tente um arquivo menor.");
            case '2':
//                    $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                $this->adicionarMensagemErro("Tamanho da imagem inválido.");
            case '3':
//                    $error = 'The uploaded file was only partially uploaded';
                $this->adicionarMensagemErro("O arquivo $arquivo não pode ser carregado completamente.<br/>Tente novamente.");
            case '4':
//                    $error = 'No file was uploaded.';
                $this->adicionarMensagemErro("Nenhum arquivo foi selecionado.");
            case '6':
//                    $error = 'Missing a temporary folder';
                $this->adicionarMensagemErro("Erro ao salvar o arquivo no servidor.");
            case '7':
//                    $error = 'Failed to write file to disk';
                $this->adicionarMensagemErro("Erro ao salvar o arquivo no servidor.");
            case '8':
//                    $error = 'File upload stopped by extension';
                $this->adicionarMensagemErro("Operação interrompida pelo servidor.");
            default:
//                    $error = 'No error code avaiable';
                $this->adicionarMensagemErro("Erro desconhecido.");
        }
        $this->abortarExecucao();
    }

    function montarNome($nomes, $separador = '-') {
        if (!is_array($nomes)) {
            return $nomes;
        } else {
            $ret = "";
            foreach ($nomes as $nome) {
                $ret .= $nome . $separador;
            }
            return preg_replace("/-$/", "", $ret);
        }
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

