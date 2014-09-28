<?php

namespace app\modelo\ferramentas\imagens;

require_once APP_DIR . 'modelo/comboboxes/ComboBoxDescritores.php';

use \app\modelo as Modelo;

class moverdescritor extends \app\modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $idDescritor = fnDecrypt(filter_input(INPUT_POST, 'idDescritor'));
        $nivel = filter_input(INPUT_POST, 'nivel', FILTER_VALIDATE_INT);
        $idNovoPai = fnDecrypt(filter_input(INPUT_POST, 'idNovoPai'));
        $idAntigoPai = fnDecrypt(filter_input(INPUT_POST, 'idAntigoPai'));

        if (is_numeric((int) $idDescritor) && is_numeric((int) $idAntigoPai) && is_numeric((int) $idNovoPai) && is_numeric($nivel)) {
            $imagensDAO = new Modelo\imagensDAO();
            //TODO Retirar essas queries desse arquivo e mover para algum método em imagensDAO para consistência da estrutura do código.
            $sqlImagensRenomear = "SELECT idImagem FROM imagem WHERE descritor$nivel = :idDescritorExcluido";
            $paramsImagensRenomear = array(
                ':idDescritorExcluido' => [$idDescritor, \PDO::PARAM_INT]
            );
            $imagensParaRenomearArquivo = $imagensDAO->executarSelect($sqlImagensRenomear, $paramsImagensRenomear);
            if ($imagensDAO->moverDescritor($idDescritor, $idNovoPai, $idAntigoPai)) {
                $imagensDAO->atualizarNomeArquivoImagens($imagensParaRenomearArquivo);
                $this->adicionarMensagemSucesso("Movido com sucesso.");
            } else {
                $this->adicionarMensagemErro("Falha ao mover.");
            }
        } else {
            $this->adicionarMensagemErro("Valores inconsistentes.<br/>Tente recarregar a página e tente novamente.", true);
        }
    }

}
