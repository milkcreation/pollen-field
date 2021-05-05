<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\RadioCollection;

use Pollen\Field\Drivers\RadioCollectionDriverInterface;
use Pollen\Field\Drivers\RadioDriverInterface;
use Pollen\Support\Concerns\BuildableTraitInterface;

interface RadioChoicesInterface extends BuildableTraitInterface
{
    /**
     * Résolution de sortie de la classe en tant que chaîne de caractère.
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * Initialisation
     *
     * @return static
     */
    public function build(): RadioChoicesInterface;

    /**
     * Récupération de l'instance du champ de collection de bouton radio associés.
     *
     * @return RadioCollectionDriverInterface|null
     */
    public function collector(): ?RadioCollectionDriverInterface;

    /**
     * Récupération du rendu d'affichage de l'élément.
     *
     * @return string
     */
    public function render(): string;

    /**
     * Définition de l'instance du champ de collection de bouton radio associés.
     *
     * @param RadioCollectionDriverInterface $collector
     *
     * @return static
     */
    public function setCollector(RadioCollectionDriverInterface $collector): RadioChoicesInterface;

    /**
     * Définition d'un élément.
     *
     * @param string $key
     * @param RadioChoiceInterface|RadioDriverInterface|array|string $choiceDef
     *
     * @return RadioChoiceInterface
     */
    public function setChoice(string $key, $choiceDef): RadioChoiceInterface;
}