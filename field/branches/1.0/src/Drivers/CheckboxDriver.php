<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriver;
use Pollen\Field\FieldDriverInterface;
use Pollen\Field\Drivers\LabelDriverInterface;

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
                 * Style de la case à cocher
                 * @var string|bool base|toggle|none|
                 */
                'theme'   => 'base',
                /**
                 * Intitulé de qualification
                 * @var string|array|LabelDriverInterface
                 */
                'label'   => null,
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
        $this->set('attrs.type', 'checkbox');

        if ($this->isChecked()) {
            $this->push('attrs', 'checked');
        }

        if ($theme = $this->get('theme')) {
            if ($theme === true || !in_array($theme, ['base', 'toggle', 'none'], true)) {
                $theme = 'base';
            }

            if ($theme === 'base' && !$this->get('label')) {
                $this->set('label', '');
            } elseif ($theme === 'toggle') {
                $this->set('label', '');
            }

            $this->set(
                'attrs.class',
                sprintf((($class = $this->get('attrs.class')) ? "$class %s" : "%s"), "FieldCheckbox--$theme")
            );
        } else {
            $this->set('theme', 'none');
        }

        if ($this->get('label') !== null) {
            $label = $this->get('label');

            if (!$label instanceof LabelDriverInterface) {
                $params = [
                    'attrs' => [],
                ];

                if (is_string($label)) {
                    $params['content'] = $label;
                }

                if (!($id = $this->get('attrs.id'))) {
                    $id = 'FieldCheckbox-' . $this->getIndex();
                    $this->set('attrs.id', $id);
                }
                $params['attrs']['for'] = $id;

                if (is_array($label)) {
                    $params = array_merge($params, $label);
                }

                $this->set('label', $this->field('label', $params));
            } else {
                $this->set('label', $label);
            }
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