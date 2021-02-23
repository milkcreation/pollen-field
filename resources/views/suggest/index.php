<?php
/**
 * @var Pollen\Field\FieldViewTemplateInterface $this
 */
?>
<?php $this->before(); ?>
<?php echo field('text', ['attrs' => $this->get('attrs', [])]); ?>
<?php $this->after();