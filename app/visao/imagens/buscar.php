<?php if ($this->temResultados): ?>
    <div id="paginacao_imagens">
        <?php echo $this->paginacao; ?>
    </div>
<?php endif; ?>
<div class="container-fluid blocoBranco" >
    <?php if ($this->temResultados): ?>
        <?php // print_r ($this->resultados[0]);?>
        <div style="position: relative;"> <!-- Div para limitar até onde a preview se expande -->
            <ul id="og-grid" class="og-grid">
                <?php foreach ($this->resultados as $key => $imagem) : ?>
                    <li>
                        <a href="javascript:void(0);" data-largesrc="<?php echo $imagem['diretorio'] . $imagem['nomeArquivo']; ?>" data-title="<?php echo $imagem['titulo']; ?>" data-description="<?php echo $imagem['observacoes']; ?>" data-desc1="Descritor 1">
                            <img src="<?php echo $imagem['diretorioMiniatura'] . $imagem['nomeArquivoMiniatura']; ?>" alt="img02"/>
                        </a>
<!--                        <div class="og-expander">
                            <div class="og-expander-inner">
                                <span class="og-close"></span>
                                <div class="og-fullimg">
                                    <div class="og-loading"></div>
                                    <img src="<?php // echo $imagem['diretorio'] . $imagem['nomeArquivo']; ?>">
                                </div>
                                <div class="og-details">
                                    <h3>Veggies sunt bona vobis</h3>
                                    <p>Komatsuna prairie turnip wattle seed artichoke mustard horseradish taro rutabaga ricebean carrot black-eyed pea turnip greens beetroot yarrow watercress kombu.</p>
                                    <a href="http://cargocollective.com/jaimemartinez/">Visit website</a>
                                </div>
                            </div>
                        </div>-->
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <p></p>
        <p class="textoCentralizado">Nenhum resultado</p>
    <?php endif; ?>
</div>
<br/>
<?php echo "Tempo gasto: " . $this->tempoGasto . " segundos"; ?>
<script src="publico/js/thumbnailgrid/grid.js"></script>
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
    function visualizarImagem(id) {
        return $.ajax({
            async: false
            , url: 'index.php?c=imagens&a=visualizarimagem'
            , method: "GET"
            , data: {id: id}
        }).data;
    }
    $(document).ready(function() {

        Grid.init();
        //Configura o plugin para a galeria de imagens
        //                $(".fancybox").fancybox({
        //                    closeBtn: false
        //                    , helpers: {
        //                        title: {type: 'inside'}
        //                        , buttons: {tpl: '<div id="fancybox-buttons" class="top"><ul><li><a class="btnPrev" title="Anterior" href="javascript:;"></a></li><li><a class="btnNext" title="Próximo" href="javascript:;"></a></li><li><a class="btnToggle" title="Tamanho real/reduzido" href="javascript:;"></a></li><li><a class="btnClose" title="Fechar" href="javascript:;"></a></li></ul></div>'}
        //                    }
        //                    , beforeShow: function() {
        //                        /* Disable right click */
        ////                        $.fancybox.wrap.bind("contextmenu", function(e) {
        ////                            return false;
        ////                        });
        //                    }
        //                    , mouseWheel: false
        //                    , fitToView: true
        //                });
//        $(".fancybox").slimbox({slideWidth: '100%', slideHeight: '100%', slideInterval: 5});

        $(".btn-imagem-visualizacao").tooltip({placement: 'top'});


//        var ultimoThumb;
//        var ultimoThumbTimeout;
//        $(".thumbnail").on('click', function() {
//            if (this == ultimoThumb) {
//                return;
//            } else {
//                ultimoThumb = this;
//            }
//            exibir(this);
//            $(this).addClass('clicada');
//        });
//        $(".thumbnail").on('mouseleave', function() {
//            ultimoThumbTimeout = setTimeout(function(obj) {
//                if (obj == ultimoThumb) {
//                    return;
//                }
//                $(obj).removeClass('clicada');
//                esconder(obj);
//            }, 800, this);
//            ultimoThumb = null;
//        });
        $("#qtdItensPorPagina").on('change', function() {
            buscar();
        });
    });
</script>
