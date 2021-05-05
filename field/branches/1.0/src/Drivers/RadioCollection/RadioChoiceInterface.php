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
     * Récupération de l'instance du champ radio.
     *
     * @return RadioDriverInterface
     */
    public function getRadio(): RadioDriverInterface;

    /**
     * Récupération du rendu d'affichage de l'élément.
     *
     * @return string
     */
    public function render(): string;

    /**
     * Définition de l'instance du gestionnaire de la liste de choix.
     *
     * @param RadioChoicesInterface $choices
     *
     * @return static
     */
    public function setChoices(RadioChoicesInterface $choices): RadioChoiceInterface;
}