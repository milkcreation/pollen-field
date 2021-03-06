<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriver;

class DatepickerDriver extends FieldDriver implements DatepickerDriverInterface
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
                 * @var array $options Liste des options du contrôleur ajax.
                 */
                'options' => [],
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $this->set(
            [
                'attrs.data-control' => 'datepicker',
                'attrs.data-options' => $this->get('options', []),
            ]
        );
        return parent::render();
    }


    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->field()->resources('/views/datepicker');
    }
}