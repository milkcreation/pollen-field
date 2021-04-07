<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\CheckboxCollection;

use Pollen\Field\Drivers\CheckboxCollectionDriverInterface;
use Pollen\Field\Drivers\CheckboxDriverInterface;
use Pollen\Support\Concerns\BuildableTraitInterface;

interface CheckboxChoicesInterface extends BuildableTraitInterface
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
    public function build(): CheckboxChoicesInterface;

    /**
     * Vérification d'existance d'éléments.
     *
     * @return bool
     */
    public function exists(): bool;

    /**
     * Déclaration des éléments sélectionnés.
     *
     * @return static
     */
    public function registerChecked(): CheckboxChoicesInterface;

    /**
     * Récupération du rendu d'affichage de l'élément.
     *
     * @return string
     */
    public function render(): string;

    /**
     * Définition de l'instance du champ de collection de case à cocher associé.
     *
     * @param CheckboxCollectionDriverInterface $checkboxCollection
     *
     * @return static
     */
    public function setCheckboxCollection(CheckboxCollectionDriverInterface $checkboxCollection): CheckboxChoicesInterface;

    /**
     * Définition d'un élément.
     *
     * @param string $key
     * @param CheckboxChoiceInterface|CheckboxDriverInterface|array $choiceDef
     *
     * @return CheckboxChoiceInterface
     */
    public function setChoice(string $key, $choiceDef): CheckboxChoiceInterface;
}