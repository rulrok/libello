<div id="resultadoImagens">
    <?php if ($this->temResultados): ?>
        <div class = "row-fluid">
            <ul class = "thumbnails">
                <?php foreach ($this->resultados as $chave => $imagem) : ?>
                    <li class = "span2">
                        <div class="thumbnail">
                            <img class="img-rounded" src="<?php echo $imagem['nomeArquivoMiniatura'] ?>">
                            <div class = "caption" style="display: none">
                                <h4><?php echo $imagem['titulo'] ?></h4>
                                <p class="descricao"><?php echo $imagem['observacoes'] ?></p>
                                <p><b>Tags:</b> (<?php echo $imagem['rotulo'] ?>)
                                    <br/> 
                                    <?php echo $imagem['nomedescritor1'] . '<br/>' . $imagem['nomedescritor2'] . '<br/>' . $imagem['nomedescritor3'] . '<br/>' . $imagem['nomedescritor4'] ?>
                                <p>
                                    <a href = "javascript:void(0)" class="btn btn-mini btn-info btn-imagem-visualizacao" data-toggle="Novo" title="Baixar imagem em tamanho real"><i class="icon-download-alt"></i><i class="icon-picture"></i></a>
                                    <a href = "javascript:void(0)" class="btn btn-mini btn-imagem-visualizacao" data-toggle="Novo" title="Baixar arquivo vetorizado"><i class="icon-download-alt"></i><i class="icon-file"></i></a>
                                    <a href = "javascript:void(0)" class="btn btn-mini btn-imagem-visualizacao" data-toggle="Novo" title="Mais detalhes"><i class="icon-eye-open"></i> </a>
                                </p>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <script>
            $(".btn-imagem-visualizacao").tooltip({placement: 'top'});
            function esconder(thumb) {
    //                $(thumb).children('img').removeClass('img-polaroid', 200);
                $(thumb).children('div').hide(600, function() {
                    $(thumb).parent('li').removeClass('span3', 200);
                    $(thumb).parent('li').addClass('span2', 600);
                });
            }
            function exibir(thumb) {
                $(thumb).parent('li').removeClass('span2', 200);
                $(thumb).parent('li').addClass('span3', 500);
    //                $(thumb).children('img').addClass('img-polaroid', 800);
                $(thumb).children('div').show(500);
            }
            var ultimoThumb;
            var ultimoThumbTimeout;

            $(".thumbnail").on('mouseover', function() {
                if (this == ultimoThumb) {
                    return;
                } else {
                    ultimoThumb = this;
                }
                exibir(this);
            });
            $(".thumbnail").on('mouseleave', function() {
                ultimoThumbTimeout = setTimeout(function(obj) {
                    if (obj == ultimoThumb) {
                        return;
                    }
                    esconder(obj);
                }, 800, this);
                ultimoThumb = null;
            });
        </script>
    <?php else: ?>

        <p class="textoCentralizado">Nenhum resultado</p>
    <?php endif; ?>
</div>