<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriverInterface;

interface RadioCollectionDriverInterface extends FieldDriverInterface
{
    /**
     * Récupération des valeur de selection des boutons radios.
     *
     * @return array
     */
    public function getCheckedValues(): array;
}
