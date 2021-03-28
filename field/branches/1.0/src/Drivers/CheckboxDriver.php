<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriver;
use Pollen\Field\FieldDriverInterface;

class CheckboxDriver extends FieldDriver implements CheckboxDriverInterface
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
                 * @var bool|string $checked Activation de la selection.
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
        $checked = $this->get('checked', false);

        if (is_bool($checked)) {
            return $checked;
        }

        if ($this->has('value')) {
            return in_array($checked, (array)$this->getValue(), true);
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function parseAttrValue(): FieldDriverInterface
    {
        if (($value = $this->get('checked')) && !is_bool($value)) {
            $this->set('attrs.value', $value);

            return $this;
        }
        return parent::parseAttrValue();
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $this->set('attrs.type', 'checkbox');

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
        return $this->field()->resources('/views/checkbox');
    }
}