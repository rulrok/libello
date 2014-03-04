<title>Homepage</title>
<div class="hero-unit" style="margin: 50px;margin-top: 0px;">
    <?php if (isset($this->usuario)) : ?>
        <h1><?php echo $this->usuario ?></h1>
    <?php else : ?>
        <h1>Olá</h1>
    <?php endif; ?>
    <h2>Seja bem-vindo :)</h2>
    <p>
        Você pode escolher entre as ferramentas que se encontram no menu acima.<br/>
        Este ainda é um sistema em fase alpha.
    </p>
    <?php if ($this->papel === 1): ?>
        <p>
            Submenus marcados em <span class="label label-important">vermelho</span> indicam menus exclusivamente administrativos!
        </p>
    <?php endif; ?>
</div>
