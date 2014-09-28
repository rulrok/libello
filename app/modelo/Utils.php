<?php

include_once APP_LIBRARY_ABSOLUTE_DIR . 'seguranca/seguranca.php';

/**
 * Função para registrar mensagens de logs em arquivo no servidor.
 * 
 * @param string $mensagem
 * @return boolean TRUE em caso de sucesso, FALSE em caso de erro.
 */
function registrar_erro($mensagem, Usuario $usuarioAfetado = null) {

    //O lançamento abaixo é feito para que seja capturado pelo modelo da ação, de forma que seja printado
    //na tela o erro para o usuário. Talvez futuramente este lançamento deva ser aprimorado de alguma forma.
//    throw new \Exception($mensagem);
    //Editado: Essa excecao não deve ser lançada aqui @Reuel

    $usuarioLogado = obterUsuarioSessao();
    if ($usuarioLogado !== null) {
        $usuario = "[Usuário: " . _formatarDadosUsuario($usuarioLogado) . "]";
    } else {
        $usuario = "[Usuário não logado]";
    }
    if ($usuarioAfetado !== null) {
        $usuarioAlvo = "[Usuário alvo: " . _formatarDadosUsuario($usuarioAfetado) . "]";
    } else {
        $usuarioAlvo = "";
    }

    return error_log("Mensagem: <" . $mensagem . ">\n" . $usuario . "\n" . $usuarioAlvo . "\n");
}

/**
 * Função para facilitar a linearização de alguns dados de um objeto Usuario para
 * registrar no log de eventos do sistema.
 * 
 * @param Usuario
 * @return string
 */
function _formatarDadosUsuario(\app\modelo\Usuario $u) {
    return $u->get_PNome() . ' ' . $u->get_UNome() . '(' . $u->get_iniciais() . '), ' . $u->get_email() . ', papel: ' . $u->get_idPapel() . ', id: ' . $u->get_idUsuario();
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

function removerAcentos($entrada) {
    $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
    $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
    return str_replace($a, $b, $entrada);
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

function get_php_classes($filepath) {
    $php_code = file_get_contents($filepath);
    $classes = array();
    $tokens = token_get_all($php_code);
    $count = count($tokens);
    for ($i = 2; $i < $count; $i++) {
        if ($tokens[$i - 2][0] == T_CLASS && $tokens[$i - 1][0] == T_WHITESPACE && $tokens[$i][0] == T_STRING) {

            $class_name = $tokens[$i][1];
            $classes[] = $class_name;
        }
    }
    return $classes;
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
    return rmdir($dir);
}

/**
 * Gera uma senha aleatória para uso temporário por um usuário recem cadastrado.
 * 
 * @param int $tamanhoSenha
 */
function gerarSenhaUsuario($tamanhoSenha = 8) {
    $alfabeto = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $senha = array();
    $tamanhoAlfabeto = strlen($alfabeto) - 1;
    for ($i = 0; $i < $tamanhoSenha; $i++) {
        $n = rand(0, $tamanhoAlfabeto);
        $senha[] = $alfabeto[$n];
    }
    return implode($senha); //turn the array into a string
}
