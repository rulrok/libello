<?php
print_r($_GET);
echo $_GET['userID'];
for ($i = 1 ; $i <= Ferramenta::__length; $i++){
    echo Ferramenta::get_nome_ferramenta($i);
}
?>
