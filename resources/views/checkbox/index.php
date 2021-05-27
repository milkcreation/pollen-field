<?php
/**
 * @var Pollen\Field\FieldViewLoaderInterface $this
 */
?>
<?php $this->before(); ?>
<?php echo $this->partial('tag', [
    'tag'   => 'input',
    'attrs' => $this->get('attrs', []),
]);
?>
<?php echo $this->get('label'); ?>
<?php $this->after();