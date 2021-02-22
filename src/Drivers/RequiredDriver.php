<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriver;

class RequiredDriver extends FieldDriver implements RequiredDriverInterface
{
    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->fieldManager()->resources('/views/required');
    }
}
