<?php

$idDescritor = fnDecrypt(filter_input(INPUT_POST, 'idDescritor'));
$idDescritorSubstituto = fnDecrypt(filter_input(INPUT_POST, 'idDescritorSubstituto'));

$imagensDAO = new imagensDAO();
try {
    $imagensDAO->iniciarTransacao();

    $descritorExcluido = $imagensDAO->consultarDescritor('*', " idDescritor = $idDescritor")[0];

    $caminhoNovo = $imagensDAO->consultarCaminhoAteRaiz($idDescritorSubstituto);

    //TODO Retirar essas queries desse arquivo e mover para algum método em imagensDAO para consistência da estrutura do código.
    switch ($descritorExcluido['nivel']) {
        case '1':
            $sql = "UPDATE imagem SET descritor1 = :descritor1, descritor2 = :descritor2, descritor3 = :descritor3, descritor4 = :descritor4 WHERE descritor1 = :descritorExcluir";
            $sqlImagensRenomear = "SELECT idImagem FROM imagem WHERE descritor1 = :descritorExcluir";
            break;
        case '2':
            $sql = "UPDATE imagem SET descritor1 = :descritor1, descritor2 = :descritor2, descritor3 = :descritor3, descritor4 = :descritor4 WHERE descritor2 = :descritorExcluir";
            $sqlImagensRenomear = "SELECT idImagem FROM imagem WHERE descritor2 = :descritorExcluir";
            break;
        case '3':
            $sql = "UPDATE imagem SET descritor1 = :descritor1, descritor2 = :descritor2, descritor3 = :descritor3, descritor4 = :descritor4 WHERE descritor3 = :descritorExcluir";
            $sqlImagensRenomear = "SELECT idImagem FROM imagem WHERE descritor3 = :descritorExcluir";
            break;
        case '4':
            $sql = "UPDATE imagem SET descritor1 = :descritor1, descritor2 = :descritor2, descritor3 = :descritor3, descritor4 = :descritor4 WHERE descritor4 = :descritorExcluir";
            $sqlImagensRenomear = "SELECT idImagem FROM imagem WHERE descritor4 = :descritorExcluir";
            break;
    }
    $paramsAtualizar = array(
        ':descritor1' => [$caminhoNovo[0]['idDescritor'], \PDO::PARAM_INT]
        , ':descritor2' => [$caminhoNovo[1]['idDescritor'], \PDO::PARAM_INT]
        , ':descritor3' => [$caminhoNovo[2]['idDescritor'], \PDO::PARAM_INT]
        , ':descritor4' => [$caminhoNovo[3]['idDescritor'], \PDO::PARAM_INT]
        , ':descritorExcluir' => [$idDescritor, \PDO::PARAM_INT]
    );

    $paramsImagensRenomear = array(
        ':descritorExcluir' => [$idDescritor, \PDO::PARAM_INT]
    );

    $imagensParaRenomearArquivo = $imagensDAO->executarSelect($sqlImagensRenomear, $paramsImagensRenomear);

    $imagensDAO->executarQuery($sql, $paramsAtualizar);

    if ($descritorExcluido['pai'] != null) {
        $sqlAtualizaQtdFilhos = 'UPDATE imagem_descritor SET qtdFilhos = qtdFilhos - 1 WHERE idDescritor = :idDescritor';
        $paramsAtualizarQtdFilhos = array(
            ':idDescritor' => [$descritorExcluido['pai'], \PDO::PARAM_INT]
        );
        $imagensDAO->executarQuery($sqlAtualizaQtdFilhos, $paramsAtualizarQtdFilhos);
    } else {
        throw new Exception("Tentativa de excluir descritor raiz");
    }
    $sqlRemover = 'DELETE FROM imagem_descritor WHERE idDescritor = :idDescritorRemover';
    $paramsRemover = array(
        ':idDescritorRemover' => [$idDescritor, \PDO::PARAM_INT]
    );
    if ($imagensDAO->executarQuery($sqlRemover, $paramsRemover)) {
        //Deve-se agora renomear os arquivos afetados pela mudança de descritores, para manter a consistência com o nome dos arquivos em relação aos rótulos
        //cadastrados para os novos descritores que substituirão os antigos.
        $imagensDAO->atualizarNomeArquivoImagens($imagensParaRenomearArquivo);
        
        $imagensDAO->encerrarTransacao();
    } else {
        throw new Exception("Falha ao remover descritor do banco.");
    }
} catch (Exception $e) {
    $imagensDAO->rollback();
}
