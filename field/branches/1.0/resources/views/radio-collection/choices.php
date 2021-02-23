<?php
/**
 * @var Pollen\Field\FieldViewTemplateInterface $this
 * @var tiFy\Contracts\Field\RadioChoice $item
 */
?>
<ul class="FieldRadioCollection-choices">
    <?php foreach ($this->get('items', []) as $item) : ?>
    <li class="FieldRadioCollection-choice">
        <?php echo $item;?>
    </li>
    <?php endforeach; ?>
</ul>