<?php
/**
 * @var Pollen\Field\FieldTemplateInterface $this
 */
?>
<?php $this->before(); ?>
<nav <?php $this->attrs(); ?>>
    <?php $this->insert('choices', $this->all()); ?>
</nav>
<?php $this->after();