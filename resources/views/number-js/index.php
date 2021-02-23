<?php
/**
 * @var Pollen\Field\FieldViewTemplateInterface $this
 */
?>
<?php $this->before(); ?>
    <div <?php echo $this->htmlAttrs($this->get('container.attrs', [])); ?>>
        <?php echo partial('tag', [
            'tag'   => 'input',
            'attrs' => $this->get('attrs', []),
        ]); ?>
    </div>
<?php $this->after();