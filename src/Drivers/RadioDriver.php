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
                 * Intitulé de qualification
                 * @var string|null
                 */
                'label'   => null,
                /**
                 * Valeur de sélection du bouton radio.
                 * @var string $checked
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
        $value = $this->pull('value');
        if ($value !== null) {
            $this->setCheckedValue((string)$value);
        }

        $checked = $this->pull('checked');
        if ($checked !== null) {
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

        if ($label = $this->get('label')) {
            $params = [
                'attrs'   => [],
                'content' => $label,
            ];

            if (!($id = $this->get('attrs.id'))) {
                $id = 'FieldRadio-' . $this->getIndex();
                $this->set('attrs.id', $id);
            }
            $params['attrs']['for'] = $id;

            $this->set('label', $this->field('label', $params));
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