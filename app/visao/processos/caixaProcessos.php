<title>Arvore de processos</title>
<html>
    <body>
    <?php


          function tamanho($arquivo) {

             $tamanho = filesize($arquivo);

             $kb = 1024;
             $mb = 1048576;
             $gb = 1073741824;
             $tb = 1099511627776;

             if ($tamanho < $kb) {
                return $tamanho . " bytes";
             } elseif ($tamanho >= $kb && $tamanho < $mb) {
                $kilo = number_format($tamanho / $kb, 2);
                return $kilo . " KB";
             } elseif ($tamanho >= $mb && $tamanho < $gb) {
                $mega = number_format($tamanho / $mb, 2);
                return $mega . " MB";
             } elseif ($tamanho >= $gb && $tamanho < $tb) {
                $giga = number_format($tamanho / $gb, 2);
                return $giga . " GB";
             }
          }

          function dataMod($arquivo) {
             $data = date("d.m.Y H:i:s", filemtime($arquivo));
             return($data);
          }

          $arquivo = opendir('.');

          echo '<table width="600">
             <tr>
                <td>Pastas</td><td>Tamanho</td><td>Atualizado</td></tr>';

          $dir = opendir('.');
          $qtdArq = 0;
          $qtdDir = -2;

          while (false !== ($arq = readdir($dir))) {
             if (is_file($arq)) {
                $qtdArq++;
             } else {
                $qtdDir++;
             }
          }

          echo '         
             <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
             <tr class="info"><td>&nbsp;</td><td>Pastas: ' . $qtdDir . '</td><td>Total: ' . ($qtdArq + $qtdDir) . '</td></tr>
             <tr class="info"><td>&nbsp;</td><td>Arquivos: ' . $qtdArq . '</td><td>&nbsp;</td></tr>
             <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';

          while ($dir = readdir($arquivo)) {
             if ($dir != '..' && $dir != '.' && $dir != '') {
                if (is_dir($dir)) {
                   echo '<tr><td><a href=' . $dir . '>' .
                   '<img src="http://www.i-m-c.org/imc/images/folder-small.jpg" class="img" />' . $dir . '</a></td>              
                    <td>' . tamanho($dir) . '</td><td>' . dataMod($dir) . ' hs</td></tr>';
                } elseif (is_file($dir)) {
                   if (preg_match('/\.php$/', $dir)) {
                      echo '<tr><td><a href=' . $dir . '>' .
                      '<img src="http://www.mysticfrost.net/img/php_icon.png" />' . $dir . '</a></td>
                <td>' . tamanho($dir) . '</td><td>' . dataMod($dir) . ' hs</td></tr>';
                   } elseif (preg_match('/\.(txt|doc)$/', $dir)) {
                      echo '<tr><td><a href=' . $dir . '>' .
                      '<img src="http://www.baixamais.net/resources/banco-de-icones/documentos/doc-txt.gif" />' . $dir . '</a></td>
                <td>' . tamanho($dir) . '</td><td>' . dataMod($dir) . ' hs</td></tr>';
                   } elseif (preg_match('/\.(htm|html|xhtml)$/', $dir)) {
                      echo '<tr><td><a href=' . $dir . '>' .
                      '<img src="http://www.history.army.mil/images/HTML-globe.png" />' . $dir . '</a></td>
                <td>' . tamanho($dir) . '</td><td>' . dataMod($dir) . ' hs</td></tr>';
                   } else {
                      echo '<tr><td><a href=' . $dir . '>' .
                      '<img src="http://forum.joomlaworks.gr/Themes/JoomlaWorks/images/topic/veryhot_post.gif" />' . $dir . '</a></td>
                <td>' . tamanho($dir) . '</td><td>' . dataMod($dir) . ' hs</td></tr>';
                   }
                }
             }
          }

          echo '</table>';

          closedir($arquivo);
          clearstatcache();
          ?>
           <div class="btn-group">
                             
                            <a class="btn btn-small" href="javascript:void(0)" onclick=""><i class="icon-list"></i> Adicionar Documento.</a>
                            <a class="btn btn-small" href="javascript:void(0)" onclick="click()"><i class="icon-list"></i> Adicionar Editar.</a>
                            <!--<a class="btn btn-small" href="javascript:void(0)" onclick="window.open('#!processos|caixaProcessos','Arvore de processos')"><i class="icon-list"></i> Processos</a>-->
          </div>
        </body>
</html>


