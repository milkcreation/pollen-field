<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\Drivers\CheckboxCollection\CheckboxChoiceInterface;
use Pollen\Field\Drivers\CheckboxCollection\CheckboxChoices;
use Pollen\Field\Drivers\CheckboxCollection\CheckboxChoicesInterface;
use Pollen\Field\FieldDriver;
use Pollen\Field\FieldDriverInterface;
use Pollen\Support\Arr;

class CheckboxCollectionDriver extends FieldDriver implements CheckboxCollectionDriverInterface
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
                 * @var array|CheckboxDriverInterface[]|CheckboxChoiceInterface[]|CheckboxChoicesInterface $choices
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
    public function parseAttrName(): FieldDriverInterface
    {
        if ($name = $this->pull('name')) {
            $this->set('attrs.name', $name . '[]');
        }
        return $this;
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
        if (!$choices instanceof CheckboxChoicesInterface) {
            $choices = new CheckboxChoices($choices);
        }

        $this->set('choices', $choices->setCollector($this)->build());

        return parent::render();
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->field()->resources('/views/checkbox-collection');
    }
}