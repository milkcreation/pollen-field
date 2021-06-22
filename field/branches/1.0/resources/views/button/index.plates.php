<?php
/**
 * @var Pollen\Field\FieldTemplate $this
 */
?>
<?php $this->before(); ?>
<?php echo $this->partial('tag', [
    'tag'     => 'button',
    'attrs'   => $this->get('attrs', []),
    'content' => $this->get('content', ''),
]); ?>
<?php $this->after();