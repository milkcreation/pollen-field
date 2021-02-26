<?php

declare(strict_types=1);

namespace Pollen\Field;

use Closure;
use League\Route\Http\Exception\NotFoundException;
use Pollen\Http\ResponseInterface;
use Pollen\Routing\RouterInterface;
use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\Concerns\ConfigBagAwareTraitInterface;
use Pollen\Support\Proxy\ContainerProxyInterface;
use Pollen\Support\Proxy\RouterProxyInterface;

interface FieldManagerInterface extends
    BootableTraitInterface,
    ConfigBagAwareTraitInterface,
    ContainerProxyInterface,
    RouterProxyInterface
{
    /**
     * Récupération de la liste des pilote déclarés.
     *
     * @return FieldDriverInterface[][]
     */
    public function all(): array;

    /**
     * Chargement.
     *
     * @return static
     */
    public function boot(): FieldManagerInterface;

    /**
     * Récupération d'un champ déclaré.
     *
     * @param string $alias Alias de qualification.
     * @param string|array|null $idOrParams Identifiant de qualification ou paramètres de configuration.
     * @param array|null $params Liste des paramètres de configuration.
     *
     * @return FieldDriverInterface|null
     */
    public function get(string $alias, $idOrParams = null, ?array $params = []): ?FieldDriverInterface;

    /**
     * Récupération de l'url de traitement des requêtes XHR.
     *
     * @param string $field Alias de qualification du pilote associé.
     * @param string|null $controller Nom de qualification du controleur de traitement de la requête XHR.
     * @param array $params Liste de paramètres complémentaire transmis dans l'url
     *
     * @return string|null
     */
    public function getXhrRouteUrl(string $field, ?string $controller = null, array $params = []): ?string;

    /**
     * Déclaration d'un pilote.
     *
     * @param string $alias
     * @param string|FieldDriverInterface|Closure $driverDefinition
     * @param Closure|null $registerCallback
     *
     * @return static
     */
    public function register(
        string $alias,
        $driverDefinition,
        ?Closure $registerCallback = null
    ): FieldManagerInterface;

    /**
     * Déclaration des instances de pilotes par défaut.
     *
     * @return static
     */
    public function registerDefaultDrivers(): FieldManagerInterface;

    /**
     * Chemin absolu vers une ressource (fichier|répertoire).
     *
     * @param string|null $path Chemin relatif vers la ressource.
     *
     * @return string
     */
    public function resources(?string $path = null): string;

    /**
     * Définition du chemin absolu vers le répertoire des ressources.
     *
     * @return static
     * @var string $resourceBaseDir
     *
     */
    public function setResourcesBaseDir(string $resourceBaseDir): FieldManagerInterface;

    /**
     * Répartiteur de traitement d'une requête XHR.
     *
     * @param string $field Alias de qualification du pilote associé.
     * @param string $controller Nom de qualification du controleur de traitement de la requête.
     * @param mixed ...$args Liste des arguments passés au controleur
     *
     * @return ResponseInterface
     *
     * @throws NotFoundException
     */
    public function xhrResponseDispatcher(string $field, string $controller, ...$args): ResponseInterface;
}