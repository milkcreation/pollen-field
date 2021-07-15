<?php
/**
 * @var Pollen\Field\FieldTemplateInterface $this
 */
?>
<?php $this->before(); ?>

    <div <?php echo $this->htmlAttrs($this->get('container.attrs', [])); ?>>
        <?php echo $this->field('input', $this->all()); ?>
    </div>

<?php $this->after();