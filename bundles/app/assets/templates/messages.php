<?php

$this->layout('app:layout');
$this->set('pageTitle', 'Minhas mensagens');

?>


<h3>Minhas mensagens</h3>

<?php foreach ($pager->getCurrentItems() as $message) : ?>
<blockquote>
    <?php echo $message->text;?>
</blockquote>
<?php endforeach; ?>

<ul>
    <?php
        if ($pager->currentPage() > 1) :
            $previousPageUrl = $this->httpPath(
                'app.messages', ['page' => $pager->previousPage()]
            )
    ?>
    <li><a href="<?php echo $previousPageUrl; ?>">Anterior</a></li>
    <?php endif; ?>
    <?php
        if ($pager->currentPage() < $pager->pageCount()) :
            $nextPageUrl = $this->httpPath(
                'app.messages', ['page' => $pager->currentPage() + 1]
            )
    ?>
    <li><a href="<?php echo $nextPageUrl; ?>">Próximo</a></li>
    <?php endif; ?>
</ul>
