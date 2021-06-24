<?php
/**
 * @var Pollen\Field\FieldTemplateInterface $this
 */
?>
<?php $this->before(); ?>

    <div <?php echo $this->htmlAttrs($this->get('container.attrs', [])); ?>>
        <?php echo $this->field('input', [
            'attrs' => $this->get('attrs', []),
        ]); ?>
    </div>

<?php $this->after();