<?php
/**
 * @var Pollen\Field\FieldViewLoaderInterface $this
 */
?>
<?php $this->before(); ?>
<?php echo $this->partial('tag', [
    'tag'   => 'input',
    'attrs' => $this->get('attrs', []),
]); ?>
<?php $this->after();