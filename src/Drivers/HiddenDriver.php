<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriver;

class HiddenDriver extends FieldDriver implements HiddenDriverInterface
{
    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $this->set('attrs.type', 'hidden');

        return parent::render();
    }


    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->field()->resources('/views/hidden');
    }
}