<?php
/**
 * @var Pollen\Field\FieldTemplateInterface $this
 */
?>
<?php $this->before(); ?>

<div <?php echo $this->htmlAttrs($this->get('container.attrs', [])); ?>>
    <div class="FieldPasswordJs-wrapper">
        <a class="FieldPasswordJs-toggle"
           data-control="password-js.toggle"
           data-target="<?php echo $this->get('container.attrs.data-id'); ?>"
           href="#"
        ></a>

        <?php echo $this->field('input', [
            'attrs' => $this->get('attrs', []),
        ]); ?>
    </div>
</div>

<?php $this->after();