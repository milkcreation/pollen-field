<?php
/**
 * @var Pollen\Field\FieldTemplate $this
 */
?>
<?php $this->layout($this->get('theme') . "-wrapper", $this->all()); ?>
<?php echo $this->partial('tag', [
    'tag'   => 'input',
    'attrs' => $this->get('attrs', []),
]);
?>
<?php echo $this->get('label'); ?>