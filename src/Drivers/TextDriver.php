<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriver;

class TextDriver extends FieldDriver implements TextDriverInterface
{
    /**
     * @inheritDoc
     */
    public function render(): string
    {
        if (!$this->get('attrs.type')) {
            $this->set('attrs.type', 'text');
        }
        return parent::render();
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->fieldManager()->resources('/views/text');
    }
}