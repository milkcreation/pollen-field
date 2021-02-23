<?php
/**
 * Affichage d'un élément dans la liste de sélection.
 * ---------------------------------------------------------------------------------------------------------------------
 * @var Pollen\Field\FieldViewTemplateInterface $this
 * @var tiFy\Contracts\Field\SelectChoice $item
 */
?>
<img src="<?php echo $item->getContent(); ?>" alt="<?php echo $item->getName(); ?>" />