<?php

namespace app\modelo\ferramentas\imagens;

require_once APP_DIR . "modelo/PaginaDeAcao.php";

use \app\modelo as Modelo;

class baixarvetorial extends \app\modelo\PaginaDeAcao {

    public function _acaoPadrao() {
        $this->omitirMensagens();
        ob_clean();
        if (filter_has_var(INPUT_GET, 'idImagem')) {
            try {
                $idImagem = fnDecrypt(filter_input(INPUT_GET, 'idImagem'));
                $imagensDAO = new Modelo\imagensDAO();
                $imagem = $imagensDAO->consultarImagem($idImagem);
                $nomeArquivo = $imagem->get_nomeArquivoVetorial();
                $diretorio = $imagem->get_diretorio();
                $nomeArquivoNormalizado = preg_filter("#_.*?\.#", '.', $nomeArquivo);


                header("X-Robots-Tag: noindex, nofollow", true);
                preg_match("/(\..*)$/", $nomeArquivoNormalizado, $matches);
                if (empty($matches)) {
                    header("Content-type: text/html");
                    echo "<p>Falha ao baixar o arquivo. Contate o suporte.</p>";
                    echo '<a href="mailto:' . APP_SUPPORT_EMAIL . '">' . APP_SUPPORT_EMAIL . '</a>';
                    registrar_erro("Falha ao baixar arquivo $nomeArquivo por causa de sua extensão.");
                    exit;
                } else {
                    //MIMEs baseados na página http://kb.mediatemple.net/questions/151/MIME+Types e http://filext.com/
                    switch ($matches[0]) {
                        case '.svg':
                            header("Content-type: image/svg+xml");
                            break;
                        case '.cdr':
                            header("Content-type: application/cdr");
                            break;
                        case '.ai':
                        case '.ps':
                        case '.eps':
                            header("Content-type: application/postscript");
                            break;
                        case '.dwg':
                            header("Content-type: application/acad");
                            break;
                        case '.dwf':
                            header("Content-type: application/dwf");
                            break;
                        case '.wmd':
                            header("Content-type: application/x-ms-wmd");
                            break;
                        case '.3ds':
                            header("Content-type: application/x-3ds");
                            break;
                        case '.xcf':
                            header("Content-type: image/xcf");
                            break;
                        default:
                            //RFC 2046
                            header("Content-type: application/octet-stream");
                            break;
                    }
                    header("Content-disposition: attachment; filename=$nomeArquivoNormalizado");
                    readfile($diretorio . $nomeArquivo);
                }
            } catch (Exception $e) {
                header("Charset: UTF-8");
                echo "Erro ao processar o arquivo";
            }
        }
    }

}
