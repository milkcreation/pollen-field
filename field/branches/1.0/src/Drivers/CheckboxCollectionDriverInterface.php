<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriverInterface;

interface CheckboxCollectionDriverInterface extends FieldDriverInterface
{
    /**
     * Récupération des valeur de selection des cases à cocher.
     *
     * @return array
     */
    public function getCheckedValues(): array;
}
