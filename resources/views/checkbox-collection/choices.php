<?php
/**
 * @var Pollen\Field\FieldViewLoaderInterface $this
 * @var Pollen\Field\Drivers\CheckboxCollection\CheckboxChoiceInterface $item
 */
?>
<ul class="FieldCheckboxCollection-choices">
    <?php foreach ($this->get('items', []) as $item) : ?>
    <li class="FieldCheckboxCollection-choice">
        <?php echo $item; ?>
    </li>
    <?php endforeach; ?>
</ul>