
<?php if ($this->temResultados): ?>
    <div id="paginacao_imagens">
        <?php echo $this->paginacao; ?>
    </div>
    <div class = "row-fluid">
        <ul class = "thumbnails">
            <?php foreach ($this->resultados as $chave => $imagem) : ?>
                <li class = "span2">
                    <div class="thumbnail">
                        <img class="img-rounded" src="<?php echo $imagem['nomeArquivoMiniatura']; ?>">
                        <img class="hidden" id="<?php echo $imagem['rotulo']; ?>" src="<?php echo $imagem['nomeArquivo']; ?>">
                        <div class = "caption" style="display: none">
                            <h4 class="elementoOcultavel"><?php echo $imagem['titulo'] ?></h4>
                            <?php if (!empty($imagem['observacoes'])): ?>
                                <p class="descricao elementoOcultavel"><?php echo $imagem['observacoes'] ?></p>
                            <?php else: ?>
                                <p class="elementoOcultavel"><b>Sem descrição</b></p>
                            <?php endif; ?>
                            <p class="elementoOcultavel"><b>Descritores:</b>
                                <br/> 
                                <?php echo $imagem['nomedescritor1'] . '<br/>' . $imagem['nomedescritor2'] . '<br/>' . $imagem['nomedescritor3'] . '<br/>' . $imagem['nomedescritor4'] ?>
                            <p class="botoes_acoes_thumb">
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
    //                $(thumb).parent('li').removeClass('span3', 200);
    //                $(thumb).parent('li').addClass('span2', 600);
            });
        }
        function exibir(thumb) {
    //            $(thumb).parent('li').removeClass('span2', 200);
    //            $(thumb).parent('li').addClass('span3', 500);
    //                $(thumb).children('img').addClass('img-polaroid', 800);
            $(thumb).children('div').show(500);
        }

        var ultimoThumb;
        var ultimoThumbTimeout;

       

        $(".thumbnail").on('click', function() {
            if (this == ultimoThumb) {
                return;
            } else {
                ultimoThumb = this;
            }
            exibir(this);
            $(this).addClass('clicada');
        });
        $(".thumbnail").on('mouseleave', function() {
            ultimoThumbTimeout = setTimeout(function(obj) {
                if (obj == ultimoThumb) {
                    return;
                }
                $(obj).removeClass('clicada');
                esconder(obj);
            }, 800, this);
            ultimoThumb = null;
        });

        $("#qtdItensPorPagina").on('change', function() {
            buscar(undefined, this.value);
        });
    </script>
<?php else: ?>

    <p class="textoCentralizado">Nenhum resultado</p>
<?php endif; ?>