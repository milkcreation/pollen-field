<?php
/**
 * @var Pollen\Field\FieldViewLoaderInterface $this
 * @var Pollen\Field\Drivers\CheckboxCollection\CheckboxChoiceInterface[] $choices
 */
?>
<ul class="FieldCheckboxCollection-choices">
    <?php foreach ($choices as $choice) : ?>
        <?php $this->insert('choice', compact('choice')); ?>
    <?php endforeach; ?>
</ul>