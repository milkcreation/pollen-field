<?php
/**
 * @var Pollen\Field\FieldViewLoaderInterface $this
 */
?>
<?php $this->before(); ?>
<?php echo $this->partial('tag', [
    'tag'     => 'label',
    'attrs'   => $this->get('attrs', []),
    'content' => $this->get('content'),
]); ?>
<?php $this->after();