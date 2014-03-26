<?php if ($this->temResultados): ?>
    <div id="paginacao_imagens">
        <?php echo $this->paginacao; ?>
    </div>
<?php endif; ?>
<!--<div class="" >-->
    <?php if ($this->temResultados): ?>
        <!--<div style="position: relative;">  Div para limitar até onde a preview se expande -->
            <ul id="og-grid" class="og-grid">
                <?php foreach ($this->resultados as $key => $imagem) : ?>
                    <li>
                        <a target="_blank" href="javascript:void(0)" 
                           data-largesrc="index.php?c=imagens&a=visualizarImagem&id=<?php echo $imagem['idImagem']; ?>" 
                           data-title="<?php echo $imagem['titulo']; ?>" 
                           data-description="<?php echo $imagem['observacoes']; ?>" 
                           data-desc1="<?php echo $imagem['nomedescritor1']; ?>" 
                           data-desc2="<?php echo $imagem['nomedescritor2']; ?>" 
                           data-desc3="<?php echo $imagem['nomedescritor3']; ?>" 
                           data-desc4="<?php echo $imagem['nomedescritor4']; ?>" 
                           data-autor="<?php echo $imagem['autor']; ?>" 
                           data-cadastro="<?php echo $imagem['dataCadastro']; ?>" 
                           data-imagem="<?php echo $imagem['idImagem']; ?>" 
                           data-ano="<?php echo $imagem['ano']; ?>" 
                           data-dificuldade="<?php echo $imagem['dificuldade']; ?>"
                           >
                            <img src="<?php echo $imagem['diretorioMiniatura'] . $imagem['nomeArquivoMiniatura']; ?>" alt="<?php echo truncarTexto($imagem['observacoes']); ?>"/>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <!--</div>  /Div para limitar até onde a preview se expande--> 

    <?php else: ?>
        <p></p>
        <p class="textoCentralizado">Nenhum resultado</p>
    <?php endif; ?>
<!--</div>-->
<br/>
<?php echo "Tempo gasto: " . $this->tempoGasto . " segundos"; ?>
<!-- Dependência do plugin thumbnail-grid -->
<script src="publico/js/thumbnailgrid/modernizr.custom.js"></script>
<!-- Por algum motivo, grid.custom.js deve estar aqui e não na página inicial -->
<script src="publico/js/thumbnailgrid/grid.custom.js"></script>
<script>
    function baixarImagem(id) {
        window.open('index.php?c=imagens&a=baixarimagem&idImagem=' + id, '_blank');
    }
    function baixarOriginal(id) {
        window.open('index.php?c=imagens&a=baixarvetorial&idImagem=' + id, '_blank');
    }

    $(document).ready(function() {

        //Inicializa o plugin para detalhes da imagem ao ser clicada
        Grid.init();

        $(".btn-imagem-visualizacao").tooltip({placement: 'top'});

        $("#qtdItensPorPagina").on('change', function() {
            buscar();
        });
    });
</script>
