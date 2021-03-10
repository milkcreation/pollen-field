<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\Drivers\RadioCollection\RadioChoiceInterface;
use Pollen\Field\Drivers\RadioCollection\RadioWalker;
use Pollen\Field\Drivers\RadioCollection\RadioWalkerInterface;
use Pollen\Field\FieldDriver;

class RadioCollectionDriver extends FieldDriver implements RadioCollectionDriverInterface
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
                 * @var string|array|bool $default Valeur de sélection par défaut. Aucune si false|La première si true|Valeur(s) par défaut.
                 */
                'default' => false,
                /**
                 * @var array|RadioDriverInterface[]|RadioChoiceInterface[]|RadioWalkerInterface $choices
                 */
                'choices' => [],
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $choices = $this->get('choices', []);
        if (!$choices instanceof RadioWalkerInterface) {
            $choices = new RadioWalker($choices);
        }

        $this->set('choices', $choices->setField($this)->build());

        return parent::render();
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->field()->resources('/views/radio-collection');
    }
}