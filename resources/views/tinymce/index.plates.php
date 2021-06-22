<?php
/**
 * @var Pollen\Field\FieldTemplate $this
 */
?>
<?php $this->before(); ?>
<?php echo $this->partial('tag', [
    'tag'     => $this->get('tag', 'textarea'),
    'attrs'   => $this->get('attrs', []),
    'content' => $this->get('value', ''),
]); ?>
<?php $this->after();