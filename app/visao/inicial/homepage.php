<div class="hero-unit">
    <?php if (isset($this->usuario)) : ?>
        <h1><?php echo $this->usuario ?></h1>
    <?php else : ?>
        <h1>Olá</h1>
    <?php endif; ?>
    <h2>Seja bem-vindo :)</h2>
    <p>
        Você pode escolher entre as ferramentas que se encontram no menu acima.<br/>
        Este ainda é um sistema em fase beta.
    </p>
</div>
