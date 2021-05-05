<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriver;
use Pollen\Field\FieldDriverInterface;

class RadioDriver extends FieldDriver implements RadioDriverInterface
{
    /**
     * @var string
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
                 * @var string $checked Valeur de sélection du bouton radio.
                 */
                'checked' => 'on',
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function isChecked(): bool
    {
        return $this->getValue() === $this->checkedValue;
    }

    /**
     * @inheritDoc
     */
    public function parseAttrValue(): FieldDriverInterface
    {
        if ($value = $this->pull('value')) {
            $this->setCheckedValue((string)$value);
        }

        if ($checked = $this->pull('checked')) {
            $this->set('attrs.value', (string)$checked);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $this->set('attrs.type', 'radio');

        if ($this->isChecked()) {
            $this->push('attrs', 'checked');
        }

        return parent::render();
    }

    /**
     * @inheritDoc
     */
    public function setCheckedValue(string $checkedValue): RadioDriverInterface
    {
        $this->checkedValue = $checkedValue;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->field()->resources('/views/radio');
    }
}