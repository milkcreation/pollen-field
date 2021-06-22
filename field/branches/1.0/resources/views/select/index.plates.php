<?php
/**
 * @var Pollen\Field\FieldTemplate $this
 */
?>
<?php if ($this->get('wrapper')) : ?>
    <?php $this->layout('wrapper', $this->all()); ?>
<?php endif; ?>

<?php $this->before(); ?>
    <select <?php $this->attrs(); ?>>
        <?php foreach ($this->get('choices', []) as $choice) : ?>
            <?php $this->insert('choice', compact('choice')); ?>
        <?php endforeach; ?>
    </select>
<?php $this->after(); ?>