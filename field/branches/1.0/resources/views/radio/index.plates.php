<?php
/**
 * @var Pollen\Field\FieldTemplateInterface $this
 */
?>
<?php $this->before(); ?>

<?php echo $this->field('input', [
    'attrs' => $this->get('attrs', []),
]); ?>

<?php echo $this->get('label'); ?>
<?php $this->after();