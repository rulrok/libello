
<?php if ($this->temResultados): ?>
    <div id="paginacao_imagens">
        <?php echo $this->paginacao; ?>
    </div>
    <div class = "row-fluid">
        <ul class = "thumbnails">
            <?php foreach ($this->resultados as $chave => $imagem) : ?>
                <li class = "span2">
                    <div class="thumbnail" >
                        <img class="img-rounded" src="<?php echo $imagem['nomeArquivoMiniatura']; ?>">
                        <div class = "caption" id="<?php echo $imagem['idImagem']; ?>" style="display: none">
                            <h4><?php echo $imagem['titulo'] ?></h4>
                            <?php if (!empty($imagem['observacoes'])): ?>
                                <p class="descricao "><?php echo $imagem['observacoes'] ?></p>
                            <?php else: ?>
                                <p><b>Sem observações</b></p>
                            <?php endif; ?>
                            <b>Descritores:</b>
                            <br/> 
                            <?php echo $imagem['nomedescritor1'] . '<br/>' . $imagem['nomedescritor2'] . '<br/>' . $imagem['nomedescritor3'] . '<br/>' . $imagem['nomedescritor4'] ?>
                            <p class="botoes_acoes_thumb">
                                <a href = "javascript:baixarImagem('<?php echo $imagem['idImagem']; ?>')" class="btn btn-mini btn-info btn-imagem-download-imagem" data-toggle="Novo" title="Baixar imagem em tamanho real"><i class="icon-download-alt"></i><i class="icon-picture"></i></a>
                                <a href = "javascript:baixarOriginal('<?php echo $imagem['idImagem']; ?>')" class="btn btn-mini btn-imagem-download-original" data-toggle="Novo" title="Baixar arquivo vetorizado"><i class="icon-download-alt"></i><i class="icon-file"></i></a>
                                <a href="<?php echo $imagem['nomeArquivo']; ?>" class="btn btn-mini btn-imagem-visualizacao fancybox" rel="group" title="Mais detalhes"><i class="icon-eye-open"></i><img class="hidden" alt="Teste" > </a>
                            </p>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <script>
        function esconder(thumb) {
            //                $(thumb).children('img').removeClass('img-polaroid', 200);
            $(thumb).children('div').hide(600)
            //                $(thumb).parent('li').removeClass('span3', 200);
            //                $(thumb).parent('li').addClass('span2', 600);

        }
        function exibir(thumb) {
            //            $(thumb).parent('li').removeClass('span2', 200);
            //            $(thumb).parent('li').addClass('span3', 500);
            //                $(thumb).children('img').addClass('img-polaroid', 800);
            $(thumb).children('div').show(500);
        }
        function baixarImagem(id) {
            window.open('index.php?c=imagens&a=baixarimagem&idImagem=' + id, '_blank');
        }
        function baixarOriginal(id) {
            window.open('index.php?c=imagens&a=baixarvetorial&idImagem=' + id, '_blank');
        }
        $(document).ready(function() {
            //Configura o plugin para a galeria de imagens
            $(".fancybox").fancybox({
                closeBtn: false
                , helpers: {
                    title: {type: 'inside'}
                    , buttons: {tpl: '<div id="fancybox-buttons" class="top"><ul><li><a class="btnPrev" title="Anterior" href="javascript:;"></a></li><li><a class="btnNext" title="Próximo" href="javascript:;"></a></li><li><a class="btnToggle" title="Tamanho real/reduzido" href="javascript:;"></a></li><li><a class="btnClose" title="Fechar" href="javascript:;"></a></li></ul></div>'}
                }
            });

            $(".btn-imagem-visualizacao").tooltip({placement: 'top'});


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
                buscar();
            });
        });
    </script>
<?php else: ?>
    <p class="textoCentralizado">Nenhum resultado</p>
<?php endif; ?>