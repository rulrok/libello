<?php

include_once BIBLIOTECA_DIR . 'seguranca/seguranca.php';

/**
 * Função para registrar mensagens de logs em arquivo no servidor.
 * 
 * @param string $mensagem
 * @return boolean TRUE em caso de sucesso, FALSE em caso de erro.
 */
function registrar_erro($mensagem) {
    $u = obterUsuarioSessao();
    if ($u !== null) {
        $usuario = "[Usuário: " . $u->get_PNome() . ' ' . $u->get_UNome() . '(' . $u->get_iniciais() . '), ' . $u->get_email() . ', papel: ' . $u->get_idPapel() . ', id: ' . $u->get_idUsuario() . "]";
    } else {
        $usuario = "[Usuário não logado]";
    }

    return error_log("Mensagem: <" . $mensagem . ">\n" . $usuario . "\n");
}

function obterHoraAtual($formato = 'h:i:s') {
    return date($formato);
}

function obterDataAtual($formato = 'Y-m-j') {
    return date($formato);
}

function normalizarNomeDescritor($nome) {
    $nomeSemEspacos = rtrim(ltrim($nome));
    $nomeLowerCase = strtolower($nomeSemEspacos);
    $nomeNormalizado = ucfirst($nomeLowerCase);
    return $nomeNormalizado;
}

/**
 * Extrai a extensão do nome de um arquivo. Apenas com base na string passada,
 * nenhuma verificação de tipo é realmente feita no arquivo.
 * 
 * @param string $nomeArquivo
 */
function obterExtensaoArquivo($nomeArquivo) {
    $i = strrpos($nomeArquivo, ".");
    if (!$i) {
        return "";
    }
    $l = strlen($nomeArquivo) - $i;
    $ext = substr($nomeArquivo, $i + 1, $l);
    return $ext;
}

/**
 * Retorna uma string truncada em <code>n</code> caracteres caso seu tamanho seje
 * maior do que o limite informado para truncar e é adicionado ao final da string
 * reticências ou uma string personalizada (variável <code>$append</code>).
 * Caso o tamanho do texto a ser truncado seja menor ou igual que o limite, o texto é retornado
 * sem modificações.
 * <br/>
 * <b>Ex:</b>
 * <br/>
 * <p>
 * <code>$var = truncarTexto("Olá mundo",3);</code>
 * Nesse momento, <code>$var</code> terá "Olá..." como resultado.
 * </p>
 * <br/>
 * <p>
 * <code>$var = truncarTexto("Olá mundo",9);</code>
 * Nesse momento, <code>$var</code> terá "Olá mundo" como resultado.
 * </p>
 * @param string $texto Texto para ser truncado
 * @param int $limite Limite para o texto truncado
 * @param string $append String personalizada para ser adicionada ao final do texto truncado
 */
function truncarTexto($texto, $limite = 20, $append = "...") {
    if (!is_string($append)) {
        $append = "...";
    }
    if (str_word_count($texto, 0) > $limite) {
        $words = str_word_count($texto, 2);
        $pos = array_keys($words);
        $texto = substr($texto, 0, $pos[$limite]) . $append;
    }
    return $texto;
}

function rmdir_recursive($dir) {
    foreach (scandir($dir) as $file) {
        if ('.' === $file || '..' === $file)
            continue;
        if (is_dir("$dir/$file"))
            rmdir_recursive("$dir/$file");
        else
            unlink("$dir/$file");
    }
    rmdir($dir);
}
