<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\CheckboxCollection;

interface CheckboxChoiceInterface
{
    /**
     * Ajout d'une instance enfant.
     *
     * @param CheckboxChoiceInterface $checkboxChoice
     *
     * @return static
     */
    public function addChildren(CheckboxChoiceInterface $checkboxChoice): CheckboxChoiceInterface;

    /**
     * Activation de l'élément.
     *
     * @param bool $enabled
     *
     * @return static
     */
    public function enabled(bool $enabled = true): CheckboxChoiceInterface;

    /**
     * Récupération de la liste des instances enfants associées.
     *
     * @return CheckboxChoiceInterface[]|array
     */
    public function getChildren(): array;

    /**
     * Récupération du niveau de profondeur.
     *
     * @return int
     */
    public function getDepth(): int;

    /**
     * Récupération du groupe associé.
     *
     * @return CheckboxChoiceInterface|null
     */
    public function getGroup(): ?CheckboxChoiceInterface;

    /**
     * Récupération de l'intitulé de qualification.
     *
     * @return string
     */
    public function getLabel(): string;

    /**
     * Nom de qualification.
     */
    public function getName(): ?string;

    /**
     * Récupération de la valeur.
     *
     * @return string
     */
    public function getValue(): string;

    /**
     * Vérification d'appartenance à un groupe.
     *
     * @return bool
     */
    public function inGroup(): bool;

    /**
     * Vérifie si l'élément est actif.
     *
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * Vérifie s'il s'agit d'un groupe.
     *
     * @return bool
     */
    public function isGroup(): bool;

    /**
     * Rendu d'affichage de l'élément.
     *
     * @return string
     */
    public function render(): string;

    /**
     * Définition du niveau de profondeur.
     *
     * @param int $depth
     *
     * @return static
     */
    public function setDepth(int $depth = 0): CheckboxChoiceInterface;

    /**
     * Définition du nom de qualification.
     *
     * @param string|null $name
     *
     * @return static
     */
    public function setName(?string $name): CheckboxChoiceInterface;

    /**
     * Définition du groupe associé.
     *
     * @param CheckboxChoiceInterface $group
     *
     * @return static
     */
    public function setGroup(CheckboxChoiceInterface $group): CheckboxChoiceInterface;
}