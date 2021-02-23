<?php
/**
 * @var Pollen\Field\FieldViewTemplateInterface $this
 */
?>
<?php $this->before(); ?>
<?php echo partial('tag', [
    'tag'     => 'span',
    'attrs'   => $this->get('attrs', []),
    'content' => $this->get('content'),
]); ?>
<?php $this->after();