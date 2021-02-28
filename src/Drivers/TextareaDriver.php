<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriver;
use Pollen\Field\FieldDriverInterface;

class TextareaDriver extends FieldDriver implements TextareaDriverInterface
{
    /**
     * @inheritDoc
     */
    public function parseParams(): void
    {
        $this->parseAttrId()->parseAttrClass()->parseAttrName();
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $this->set('content', $this->get('value'));

        return parent::render();
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->field()->resources('/views/textarea');
    }
}