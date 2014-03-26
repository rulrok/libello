<?php

echo '<big>$_SERVER:</big><br/>';
echo '<table>';
foreach ($_SERVER as $key => $value) {
    echo '<tr>';
    echo '<td>'.$key . '</td><td> ' . $value . '</td>';
    echo '</tr>';
}
echo '</table><br/>';


echo phpinfo();