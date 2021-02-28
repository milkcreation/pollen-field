<?php
/**
 * @var Pollen\Field\FieldViewLoaderInterface $this
 */
?>
<?php $this->before(); ?>
<nav <?php $this->attrs(); ?>>
    <?php echo $this->get('choices'); ?>
</nav>
<?php $this->after();