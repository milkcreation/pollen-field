<?php
/**
 * @var Pollen\Field\FieldViewLoaderInterface $this
 */
?>
<?php $this->before(); ?>
<?php echo $this->partial('tag', [
    'tag'     => $this->get('tag'),
    'content' => $this->get('content', ''),
    'attrs'   => $this->get('attrs', []),
]); ?>
<?php $this->after();