<?php
/**
 * @var Pollen\Field\FieldViewLoaderInterface $this
 * @var Pollen\Field\Drivers\RadioCollection\RadioChoiceInterface $choice
 */

?>
<ul class="FieldRadioCollection-choices">
    <?php foreach ($this->get('choices', []) as $choice) : ?>
        <li class="FieldRadioCollection-choice">
            <?php echo $choice; ?>
        </li>
    <?php endforeach; ?>
</ul>