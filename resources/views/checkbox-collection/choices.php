<?php
/**
 * @var Pollen\Field\FieldViewLoaderInterface $this
 * @var Pollen\Field\Drivers\CheckboxCollection\CheckboxChoiceInterface $choice
 */

?>
<ul class="FieldCheckboxCollection-choices">
    <?php foreach ($this->get('choices', []) as $choice) : ?>
        <li class="FieldCheckboxCollection-choice">
            <?php echo $choice; ?>
        </li>
    <?php endforeach; ?>
</ul>