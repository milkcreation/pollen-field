<?php
/**
 * Affichage d'un élément dans la liste de sélection.
 * ---------------------------------------------------------------------------------------------------------------------
 * @var Pollen\Field\FieldTemplate $this
 * @var Pollen\Field\Drivers\Select\SelectChoiceInterface $item
 */
?>
<img src="<?php echo $item->getContent(); ?>" alt="<?php echo $item->getName(); ?>" />