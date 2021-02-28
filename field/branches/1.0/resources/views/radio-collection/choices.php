<?php
/**
 * @var Pollen\Field\FieldViewLoaderInterface $this
 * @var Pollen\Field\Drivers\RadioCollection\RadioChoiceInterface $item
 */
?>
<ul class="FieldRadioCollection-choices">
    <?php foreach ($this->get('items', []) as $item) : ?>
    <li class="FieldRadioCollection-choice">
        <?php echo $item;?>
    </li>
    <?php endforeach; ?>
</ul>