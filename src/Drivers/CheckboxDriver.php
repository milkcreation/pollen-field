<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriver;
use Pollen\Field\FieldDriverInterface;

class CheckboxDriver extends FieldDriver implements CheckboxDriverInterface
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
                'label' => null,
                /**
                 * Valeur de sélection de la case à cocher.
                 * @var string
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
        $this->set('attrs.type', 'checkbox');

        if ($this->isChecked()) {
            $this->push('attrs', 'checked');
        }

        if ($label = $this->get('label')) {
            $params = [
                'attrs'   => [],
                'content' => $label
            ];

            if (!($id = $this->get('attrs.id'))) {
                $id = 'FieldCheckbox-' . $this->getIndex();
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
    public function setCheckedValue(string $checkedValue): CheckboxDriverInterface
    {
        $this->checkedValue = $checkedValue;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->field()->resources('/views/checkbox');
    }
}