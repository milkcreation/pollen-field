<?php
/**
 * @var Pollen\Field\FieldTemplateInterface $this
 */
?>
<?php $this->before(); ?>

<?php echo $this->field('input', [
    'attrs' => $this->get('attrs', []),
]); ?>

<?php $this->after();