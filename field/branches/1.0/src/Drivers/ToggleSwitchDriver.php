<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriver;

class ToggleSwitchDriver extends FieldDriver implements ToggleSwitchDriverInterface
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
                 * @var string $value
                 */
                'value'     => 'on',
                /**
                 * @var string $label_on
                 */
                'label_on'  => 'Oui',
                /**
                 * @var string $label_off
                 */
                'label_off' => 'Non',
                /**
                 * @var bool|int|string $value_on
                 */
                'value_on'  => 'on',
                /**
                 * @var bool|int|string $value_off
                 */
                'value_off' => 'off',
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->get('attrs.name') ?: $this->get('name', md5($this->getId()));
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $this->set('attrs.data-control', 'toggle-switch');

        return parent::render();
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->field()->resources('/views/toggle-switch');
    }
}