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
     * Vérification d'existence d'éléments.
     *
     * @return bool
     */
    public function exists(): bool;

    /**
     * Déclaration des éléments sélectionnés.
     *
     * @return static
     */
    public function registerChecked(): RadioChoicesInterface;

    /**
     * Récupération du rendu d'affichage de l'élément.
     *
     * @return string
     */
    public function render(): string;

    /**
     * Définition de l'instance de champ radio collection associé.
     *
     * @param RadioCollectionDriverInterface $radioCollection
     *
     * @return static
     */
    public function setRadioCollection(RadioCollectionDriverInterface $radioCollection): RadioChoicesInterface;

    /**
     * Définition d'un élément.
     *
     * @param string $key
     * @param RadioChoiceInterface|RadioDriverInterface|array $choiceDef
     *
     * @return RadioChoiceInterface
     */
    public function setChoice(string $key, $choiceDef): RadioChoiceInterface;
}