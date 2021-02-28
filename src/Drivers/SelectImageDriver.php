<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\Drivers\Select\SelectChoiceInterface;
use Pollen\Field\Drivers\SelectImage\SelectImageChoices;
use Pollen\Field\Drivers\SelectImage\SelectImageChoicesInterface;
use Pollen\Field\FieldDriver;

class SelectImageDriver extends FieldDriver implements SelectImageDriverInterface
{
    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(
            parent::defaultParams(),
            [
                /**
                 * @var string|string[]|array|SelectChoiceInterface[]|SelectImageChoicesInterface $choices Chemin absolu vers les éléments de la liste de selection|Liste de selection d'éléments.
                 */
                'choices' => [],
                /**
                 * @var bool $none Activation de la valeur d'affichage si aucun élément n'est sélectionné.
                 */
                'none'    => true,
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $this->set('attrs.class', trim($this->get('attrs.class', '%s') . ' FieldSelectJs FieldSelectImage'));

        $choices = $this->get('choices', []);
        if (!$choices instanceof SelectImageChoicesInterface) {
            $choices = new SelectImageChoices($choices, $this->getValue(), $this);
        }

        $this->set('choices', $choices->setField($this));

        return parent::render();
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->field()->resources('/views/select-image');
    }
}