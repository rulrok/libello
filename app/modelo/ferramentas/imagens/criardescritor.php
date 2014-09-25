<?php

namespace app\modelo\ferramentas\imagens;

require_once APP_DIR . 'modelo/vo/Descritor.php';

use app\modelo as Modelo;

class criardescritor extends Modelo\PaginaDeAcao {

    protected function _acaoPadrao() {
        $idPai = (int) fnDecrypt(filter_input(INPUT_POST, 'idPai'));
        $nome = filter_input(INPUT_POST, 'nome');
        $nomeNormalizado = normalizarNomeDescritor($nome);

        if (is_numeric($idPai) && !empty($nomeNormalizado)) {
            $imagensDAO = new Modelo\imagensDAO();
            $descritor = new Modelo\Descritor();
            $descritor->set_nome($nomeNormalizado);
            $imagensDAO->iniciarTransacao();
            if ($imagensDAO->cadastrarDescritor($descritor, $idPai)) {
                $ultimoDescritor = $imagensDAO->consultarDescritor('idDescritor, nome, nivel', "nome = :nome AND pai = :pai ORDER BY idDescritor DESC LIMIT 1", null, array(':nome' => [$nomeNormalizado, \PDO::PARAM_STR], ':pai' => [$idPai, \PDO::PARAM_INT]));
                if (sizeof($ultimoDescritor) > 0) {
                    $this->adicionarMensagemPersonalizada("img_novodescritor", json_encode(
                                    [
                                        'id' => fnEncrypt($ultimoDescritor[0]['idDescritor'])
                                        , 'nome' => $ultimoDescritor[0]['nome']
                                        , 'nivel' => $ultimoDescritor[0]['nivel']
                                    ]
                    ));
                    $this->adicionarMensagemSucesso("Descritor cadastrado com sucesso.");
                    $imagensDAO->encerrarTransacao();
                } else {
                    $this->adicionarMensagemErro("Falha ao cadastrar no banco.<br/> Erro 0x0801.");
                    $imagensDAO->rollback();
                }
            } else {
                $this->adicionarMensagemErro("Falha ao cadastrar no banco.<br/> Erro 0x0802.");
                $imagensDAO->rollback();
            }
        } else {
            $this->adicionarMensagemErro("Houve algum problema ao processar o nome do descrito.<br/>Remova caracteres especiais e tente novamente.");
        }
    }

}
