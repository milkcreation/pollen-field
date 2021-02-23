<?php
/**
 * @var Pollen\Field\FieldViewTemplateInterface $this
 */
?>
<?php $this->before(); ?>
<?php echo partial('tag', [
    'tag'   => 'input',
    'attrs' => $this->get('attrs', []),
]);
?>
<?php $this->after();