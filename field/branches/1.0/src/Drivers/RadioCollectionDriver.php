<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriverInterface;
use Pollen\Field\Drivers\RadioCollection\RadioChoiceInterface;
use Pollen\Field\Drivers\RadioCollection\RadioChoiceCollection;
use Pollen\Field\Drivers\RadioCollection\RadioChoiceCollectionInterface;
use Pollen\Field\FieldDriver;

class RadioCollectionDriver extends FieldDriver implements RadioCollectionDriverInterface
{
    /**
     * @var string|null
     */
    protected $checkedValue;

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(
            parent::defaultParams(),
            [
                /**
                 * @var array|RadioDriverInterface[]|RadioChoiceInterface[]|RadioChoiceCollectionInterface $choices
                 */
                'choices' => [],
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getCheckedValue(): ?string
    {
        return $this->checkedValue;
    }

    /**
     * @inheritDoc
     */
    public function parseAttrValue(): FieldDriverInterface
    {
        if ($value = $this->pull('value')) {
            $this->checkedValue = (string)$value;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $choices = $this->get('choices', []);
        if (!$choices instanceof RadioChoiceCollectionInterface) {
            $this->set('choices', $choices = new RadioChoiceCollection($choices));
        }
        $choices->setName($this->getName())->setChecked($this->getCheckedValue())->walk();

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