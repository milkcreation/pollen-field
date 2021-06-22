<?php
/**
 * @var Pollen\Field\FieldTemplate $this
 */
?>
<?php $this->before(); ?>
<?php echo $this->field('text', [
    'name'  => $this->getName(),
    'attrs' => $this->get('attrs', []),
    'value' => $this->getValue(),
]); ?>
<?php $this->after();