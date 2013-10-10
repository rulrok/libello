<?php

require_once __DIR__ . '/../configuracoes.php';

function fnEncrypt($sValue, $sSecretKey = SECRET) {
    $Rsalt = "@ILH987" . time();
    $Lsalt = rand(0, 100) . "789HLI@";
    $fValue = $Lsalt . $sValue . $Rsalt;
//    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
//    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $sSecretKey, $fValue, MCRYPT_MODE_ECB));
}

function fnDecrypt($sValue, $sSecretKey = SECRET) {
    $sValue = str_replace(" ", "+", $sValue);
//    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
//    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $value = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $sSecretKey, base64_decode($sValue), MCRYPT_MODE_ECB));

    if (preg_match("#^[0-9]+[a-zA-Z]+@.*@[a-zA-Z]+[0-9]+#", $value)) {
        $fValue = preg_replace("#^[0-9]+[a-zA-Z]+@#", "", $value);
        if ($fValue !== false) {
            $fValue = preg_replace("#@[a-zA-Z]+[0-9]+#", "", $fValue);
            if ($fValue === false) {
                die("Erro ao decodificar ID");
            }
        } else {
            die("Erro ao decodificar ID");
        }
        return $fValue;
    } else {
        die ("Código inválido");
    }
}

//$inicial = time();
//$crypt = fnEncrypt("20");
//echo $crypt . "<br/>";
//$final = time();
//echo fnDecrypt($crypt)."<br/>";
//echo "Inicial: ".$inicial."<br/>";
//echo "Final: ".$final;
//if (isset($_GET['id']))
//    echo fnDecrypt($_GET['id']);
?>
