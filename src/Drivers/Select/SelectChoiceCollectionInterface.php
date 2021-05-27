<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\Select;

use Iterator;

interface SelectChoiceCollectionInterface extends Iterator
{
    /**
     * Ajout d'une instance de choix de sélection.
     *
     * @param SelectChoiceInterface $selectChoice
     *
     * @return static
     */
    public function addChoice(SelectChoiceInterface $selectChoice): SelectChoiceCollectionInterface;

    /**
     * Définition de(s) élement(s) sélectionné de la liste de choix.
     *
     * @param string|int|array $selected
     *
     * @return static
     */
    public function setSelected($selected): SelectChoiceCollectionInterface;

    /**
     * Itérateur.
     *
     * @param array|null $selectChoiceDefs
     * @param int $depth
     * @param SelectChoiceInterface|null $optGroup
     *
     * @return SelectChoiceCollectionInterface
     */
    public function walk(
        ?array $selectChoiceDefs = null,
        int $depth = 0,
        ?SelectChoiceInterface $optGroup = null
    ): SelectChoiceCollectionInterface;
}