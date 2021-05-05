<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\Select;

interface SelectChoicesInterface
{
    /**
     * Résolution de sortie de la classe sous la forme d'une chaîne de caractères.
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * Traitement de cartographie d'un élément de la liste.
     *
     * @return static
     */
    public function map($name, $attrs, $parent = null): SelectChoicesInterface;

    /**
     * Affichage de la liste des éléments.
     *
     * @return string
     */
    public function render(): string;

    /**
     * Itérateur d'affichage.
     *
     * @param SelectChoice[] $items Liste des éléments à ordonner.
     * @param int $depth Niveau de profondeur.
     * @param string $parent Nom de qualification de l'élément parent.
     *
     * @return string
     */
    public function walker($items = [], $depth = 0, $parent = null): string;
}