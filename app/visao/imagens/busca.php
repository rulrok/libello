<div class = "row-fluid">
    <ul class = "thumbnails">
        <?php
        if ($this->temResultados):

            foreach ($this->resultados as $chave => $imagem) :
                ?>


                <li class = "span2">
                    <div class="thumbnail">
                        <img class="" src="<?php echo $imagem['nomeArquivoMiniatura'] ?>">
                        <div class = "caption">
                            <h4><?php echo $imagem['titulo'] ?></h4>
        <!--                            <p style = "font-size: 85%;"><?php echo $imagem['observacoes'] ?></p>
                            <p><b>Categoria: </b></p>
                            <p><b>Subcategoria: </b></p>
                            <p><b>Tags: </b>
                            <p><a href = "javascript:void(0)" class = "btn btn-primary">Arquivo fonte</a> <a href = "javascript:void(0)" class = "btn">Visualizar</a></p>-->
                        </div>
                    </div>
                </li>


            <?php endforeach;
            ?>
        </ul>
    </div>
<?php else: ?>
    <p>Nenhum resultado</p>
<?php endif; ?>