<?php
/**
 * @var Pollen\Field\FieldViewLoaderInterface $this
 */
?>
<?php $this->before(); ?>
<?php echo $this->partial('tag', [
    'tag'     => 'textarea',
    'attrs'   => $this->get('attrs', []),
    'content' => $this->get('content'),
]); ?>
<?php $this->after();