<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\Select;

interface SelectChoiceInterface
{
    /**
     * Ajout d'une instance de selection enfant.
     *
     * @param SelectChoiceInterface $selectChoice
     *
     * @return static
     */
    public function addChildren(SelectChoiceInterface $selectChoice): SelectChoiceInterface;

    /**
     * Activation de la sélection de l'élément.
     *
     * @param bool $enabled
     *
     * @return static
     */
    public function enabled(bool $enabled = true): SelectChoiceInterface;

    /**
     * Récupération de la liste des instances des enfants associés.
     *
     * @return SelectChoiceInterface[]|array
     */
    public function getChildren(): array;

    /**
     * Récupération du niveau de profondeur.
     *
     * @return int
     */
    public function getDepth(): int;

    /**
     * Récupération de l'intitulé de qualification.
     *
     * @return string
     */
    public function getLabel(): string;

    /**
     * Récupération du parent associé.
     *
     * @return SelectChoiceInterface|null
     */
    public function getGroup(): ?SelectChoiceInterface;

    /**
     * Récupération de la valeur.
     *
     * @return string
     */
    public function getValue(): string;

    /**
     * Vérifie si l'élément appartient à un groupe.
     *
     * @return bool
     */
    public function inGroup(): bool;

    /**
     * Vérifie si l'élement est un groupe.
     *
     * @return bool
     */
    public function isGroup(): bool;

    /**
     * Vérifie si l'élément est actif.
     *
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * Définition du niveau de profondeur.
     *
     * @param int $depth
     *
     * @return static
     */
    public function setDepth(int $depth = 0): SelectChoiceInterface;

    /**
     * Définition du groupe de selection associé.
     *
     * @param SelectChoiceInterface $group
     *
     * @return static
     */
    public function setGroup(SelectChoiceInterface $group): SelectChoiceInterface;

    /**
     * Balise de fermeture.
     *
     * @return string
     */
    public function tagClose(): string;

    /**
     * Contenu de la balise.
     *
     * @return string
     */
    public function tagBody(): string;

    /**
     * Balise d'ouverture.
     *
     * @return string
     */
    public function tagOpen(): string;
}