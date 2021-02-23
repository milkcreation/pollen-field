<?php
/**
 * Affichage d'un élément sélectionné.
 * ---------------------------------------------------------------------------------------------------------------------
 * @var Pollen\Field\FieldViewTemplateInterface $this
 * @var tiFy\Contracts\Field\SelectChoice $item
 */
?>
<img src="<?php echo $item->getContent(); ?>" alt="<?php echo $item->getName(); ?>" />