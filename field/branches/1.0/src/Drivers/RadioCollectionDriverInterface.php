<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriverInterface;

interface RadioCollectionDriverInterface extends FieldDriverInterface
{
    /**
     * Récupération de la valeur de selection des boutons radios.
     *
     * @return string|null
     */
    public function getCheckedValue(): ?string;
}
