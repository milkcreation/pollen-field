<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\CheckboxCollection;

use Iterator;

interface CheckboxChoiceCollectionInterface extends Iterator
{
    /**
     * Ajout d'une instance à la liste des éléments.
     *
     * @param CheckboxChoiceInterface $checkboxChoice
     *
     * @return static
     */
    public function addChoice(CheckboxChoiceInterface $checkboxChoice): CheckboxChoiceCollectionInterface;

    /**
     * Définition de(s) élement(s) actif de la liste.
     *
     * @param string|int|array $checked
     *
     * @return static
     */
    public function setChecked($checked): CheckboxChoiceCollectionInterface;

    /**
     * Définition du nom de qualification des éléments de la liste.
     *
     * @param string|null $name
     *
     * @return static
     */
    public function setName(?string $name): CheckboxChoiceCollectionInterface;

    /**
     * Itérateur.
     *
     * @param array|null $checkboxChoiceDefs
     * @param int $depth
     * @param CheckboxChoiceInterface|null $group
     *
     * @return CheckboxChoiceCollectionInterface
     */
    public function walk(
        ?array $checkboxChoiceDefs = null,
        int $depth = 0,
        ?CheckboxChoiceInterface $group = null
    ): CheckboxChoiceCollectionInterface;
}