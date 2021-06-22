<?php
/**
 * @var Pollen\Field\FieldTemplate $this
 */
?>
<?php $this->before(); ?>
    <div <?php echo $this->htmlAttrs($this->get('container.attrs', [])); ?>>
        <?php echo $this->partial('tag', [
            'tag'   => 'input',
            'attrs' => $this->get('attrs', []),
        ]); ?>
    </div>
<?php $this->after();