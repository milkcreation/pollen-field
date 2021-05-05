<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriverInterface;

interface CheckboxDriverInterface extends FieldDriverInterface
{
    /**
     * Vérification de correspondance entre la valeur de selection courante et celle du champ.
     *
     * @return bool
     */
    public function isChecked(): bool;

    /**
     * Définition de la valeur de selection courante de la case à cocher.
     *
     * @param string $checkedValue
     *
     * @return static
     */
    public function setCheckedValue(string $checkedValue): CheckboxDriverInterface;
}