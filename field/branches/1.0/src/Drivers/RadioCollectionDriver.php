<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriverInterface;
use Pollen\Field\Drivers\RadioCollection\RadioChoiceInterface;
use Pollen\Field\Drivers\RadioCollection\RadioChoices;
use Pollen\Field\Drivers\RadioCollection\RadioChoicesInterface;
use Pollen\Field\FieldDriver;
use Pollen\Support\Arr;

class RadioCollectionDriver extends FieldDriver implements RadioCollectionDriverInterface
{
    /**
     * @var array
     */
    protected $checkedValues = [];

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(
            parent::defaultParams(),
            [
                /**
                 * @var array|RadioDriverInterface[]|RadioChoiceInterface[]|RadioChoicesInterface $choices
                 */
                'choices' => [],
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getCheckedValues(): array
    {
        return $this->checkedValues;
    }

    /**
     * @inheritDoc
     */
    public function parseAttrValue(): FieldDriverInterface
    {
        if ($value = $this->pull('value')) {
            $this->checkedValues = Arr::wrap($value);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $choices = $this->get('choices', []);
        if (!$choices instanceof RadioChoicesInterface) {
            $choices = new RadioChoices($choices);
        }

        $this->set('choices', $choices->setCollector($this)->build());

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