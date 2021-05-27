<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\RadioCollection;

use Iterator;

interface RadioChoiceCollectionInterface extends Iterator
{
    /**
     * Ajout d'une instance à la liste des éléments.
     *
     * @param RadioChoiceInterface $radioChoice
     *
     * @return static
     */
    public function addChoice(RadioChoiceInterface $radioChoice): RadioChoiceCollectionInterface;

    /**
     * Définition de(s) élement(s) actif(s) de la liste.
     *
     * @param string|int|array $checked
     *
     * @return static
     */
    public function setChecked($checked): RadioChoiceCollectionInterface;

    /**
     * Définition du nom de qualification des éléments de la liste.
     *
     * @param string|null $name
     *
     * @return static
     */
    public function setName(?string $name): RadioChoiceCollectionInterface;

    /**
     * Itérateur.
     *
     * @param array|null $radioChoiceDefs
     * @param int $depth
     * @param RadioChoiceInterface|null $group
     *
     * @return RadioChoiceCollectionInterface
     */
    public function walk(
        ?array $radioChoiceDefs = null,
        int $depth = 0,
        ?RadioChoiceInterface $group = null
    ): RadioChoiceCollectionInterface;
}