<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriver;
use Pollen\Field\FieldDriverInterface;
use Pollen\Support\Arr;

class RadioDriver extends FieldDriver implements RadioDriverInterface
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
        if ($this->getValue()) {
            return in_array($this->get('checked'), $this->getValue(), true);
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function parseAttrValue(): FieldDriverInterface
    {
        if ($value = $this->get('value')) {
            $this->set('value', Arr::wrap($value));
        }

        if ($this->get('checked') !== null) {
            $this->set('attrs.value', (string)$this->get('checked'));

            return $this;
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
    public function viewDirectory(): string
    {
        return $this->field()->resources('/views/radio');
    }
}