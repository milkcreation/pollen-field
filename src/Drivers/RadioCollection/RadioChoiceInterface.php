<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\RadioCollection;

use Pollen\Field\Drivers\LabelDriverInterface;
use Pollen\Field\Drivers\RadioDriverInterface;
use Pollen\Support\Concerns\BuildableTraitInterface;
use Pollen\Support\Concerns\ParamsBagDelegateTraitInterface;

interface RadioChoiceInterface extends BuildableTraitInterface, ParamsBagDelegateTraitInterface
{
    /**
     * Résolution de sortie de la classe sous la forme d'une chaîne de caractères.
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * Initialisation.
     *
     * @return static
     */
    public function build(): RadioChoiceInterface;

    /**
     * Récupération du l'identifiant de qualification de l'élément.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Récupération de l'instance du champ label.
     *
     * @return LabelDriverInterface
     */
    public function getLabel(): LabelDriverInterface;

    /**
     * Récupération du nom de soumission de la requête de traitement.
     *
     * @return string
     */
    public function getNameAttr(): string;

    /**
     * Récupération de l'instance du champ radio.
     *
     * @return RadioDriverInterface
     */
    public function getRadio(): RadioDriverInterface;

    /**
     * Récupération de la valeur de soumission de la requête de traitement.
     *
     * @return mixed|null
     */
    public function getValue();

    /**
     * Vérification de l'indicateur de selection de l'élément.
     *
     * @return bool
     */
    public function isChecked(): bool;

    /**
     * Récupération du rendu d'affichage de l'élément.
     *
     * @return string
     */
    public function render(): string;

    /**
     * Définition du nom de soumission de la requête de traitement.
     *
     * @param string $name
     *
     * @return static
     */
    public function setNameAttr(string $name): RadioChoiceInterface;

    /**
     * Définition de la selection de l'élément pour la requête de traitement.
     *
     * @return static
     */
    public function setChecked(): RadioChoiceInterface;

    /**
     * Définition de l'instance du gestionnaire de la liste de choix.
     *
     * @param RadioChoicesInterface $choices
     *
     * @return static
     */
    public function setChoices(RadioChoicesInterface $choices): RadioChoiceInterface;
}