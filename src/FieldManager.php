<?php

declare(strict_types=1);

namespace Pollen\Field;

use Closure;
use Exception;
use InvalidArgumentException;
use Pollen\Field\Drivers\InputDriver;
use Pollen\Support\Concerns\ResourcesAwareTrait;
use Pollen\Support\Proxy\RouterProxy;
use Pollen\Field\Drivers\ButtonDriver;
use Pollen\Field\Drivers\CheckboxCollectionDriver;
use Pollen\Field\Drivers\CheckboxDriver;
use Pollen\Field\Drivers\ColorpickerDriver;
use Pollen\Field\Drivers\DatepickerDriver;
use Pollen\Field\Drivers\DatetimeJsDriver;
use Pollen\Field\Drivers\FileDriver;
use Pollen\Field\Drivers\FileJsDriver;
use Pollen\Field\Drivers\HiddenDriver;
use Pollen\Field\Drivers\LabelDriver;
use Pollen\Field\Drivers\NumberDriver;
use Pollen\Field\Drivers\NumberJsDriver;
use Pollen\Field\Drivers\PasswordDriver;
use Pollen\Field\Drivers\PasswordJsDriver;
use Pollen\Field\Drivers\RadioCollectionDriver;
use Pollen\Field\Drivers\RadioDriver;
use Pollen\Field\Drivers\RepeaterDriver;
use Pollen\Field\Drivers\RequiredDriver;
use Pollen\Field\Drivers\SelectDriver;
use Pollen\Field\Drivers\SelectImageDriver;
use Pollen\Field\Drivers\SelectJsDriver;
use Pollen\Field\Drivers\SubmitDriver;
use Pollen\Field\Drivers\SuggestDriver;
use Pollen\Field\Drivers\TextareaDriver;
use Pollen\Field\Drivers\TextDriver;
use Pollen\Field\Drivers\TextRemainingDriver;
use Pollen\Field\Drivers\TinymceDriver;
use Pollen\Field\Drivers\ToggleSwitchDriver;
use Pollen\Http\ResponseInterface;
use Pollen\Routing\RouteInterface;
use Pollen\Support\Concerns\BootableTrait;
use Pollen\Support\Concerns\ConfigBagAwareTrait;
use Pollen\Support\Exception\ManagerRuntimeException;
use Pollen\Support\Proxy\ContainerProxy;
use Pollen\Routing\Exception\NotFoundException;
use Psr\Container\ContainerInterface as Container;

class FieldManager implements FieldManagerInterface
{
    use BootableTrait;
    use ConfigBagAwareTrait;
    use ResourcesAwareTrait;
    use ContainerProxy;
    use RouterProxy;

    /**
     * Instance principale.
     * @var static|null
     */
    private static $instance;

    /**
     * D??finition des pilotes par d??faut.
     * @var array
     */
    private $defaultDrivers = [
        'button'              => ButtonDriver::class,
        'checkbox'            => CheckboxDriver::class,
        'checkbox-collection' => CheckboxCollectionDriver::class,
        'colorpicker'         => ColorpickerDriver::class,
        'datepicker'          => DatepickerDriver::class,
        'datetime-js'         => DatetimeJsDriver::class,
        'file'                => FileDriver::class,
        'file-js'             => FileJsDriver::class,
        'hidden'              => HiddenDriver::class,
        'input'               => InputDriver::class,
        'label'               => LabelDriver::class,
        'number'              => NumberDriver::class,
        'number-js'           => NumberJsDriver::class,
        'password'            => PasswordDriver::class,
        'password-js'         => PasswordJsDriver::class,
        'radio'               => RadioDriver::class,
        'radio-collection'    => RadioCollectionDriver::class,
        'repeater'            => RepeaterDriver::class,
        'required'            => RequiredDriver::class,
        'select'              => SelectDriver::class,
        'select-image'        => SelectImageDriver::class,
        'select-js'           => SelectJsDriver::class,
        'submit'              => SubmitDriver::class,
        'suggest'             => SuggestDriver::class,
        'text'                => TextDriver::class,
        'textarea'            => TextareaDriver::class,
        'text-remaining'      => TextRemainingDriver::class,
        'tinymce'             => TinymceDriver::class,
        'toggle-switch'       => ToggleSwitchDriver::class,
    ];

    /**
     * Liste des ??l??ments d??clar??es.
     * @var FieldDriverInterface[]
     */
    private $drivers = [];

    /**
     * Liste des pilotes d??clar??s.
     * @var FieldDriverInterface[][]|Closure[][]|string[][]|array
     */
    public $driverDefinitions = [];

    /**
     * Route de traitement des requ??tes XHR.
     * @var RouteInterface|null
     */
    protected $xhrRoute;

    /**
     * @param array $config
     * @param Container|null $container
     */
    public function __construct(array $config = [], ?Container $container = null)
    {
        $this->setConfig($config);

        if ($container !== null) {
            $this->setContainer($container);
        }

        $this->setResourcesBaseDir(dirname(__DIR__) . '/resources');

        if ($this->config('boot_enabled', true)) {
            $this->boot();
        }

        if (!self::$instance instanceof static) {
            self::$instance = $this;
        }
    }

    /**
     * R??cup??ration de l'instance principale.
     *
     * @return static
     */
    public static function getInstance(): FieldManagerInterface
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        throw new ManagerRuntimeException(sprintf('Unavailable [%s] instance', __CLASS__));
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->drivers;
    }

    /**
     * @inheritDoc
     */
    public function boot(): FieldManagerInterface
    {
        if (!$this->isBooted()) {
            //events()->trigger('field.booting', [$this]);

            if ($router = $this->router()) {
                $this->xhrRoute = $router->xhr(
                    '/api/' . md5('field') . '/{field}/{controller}',
                    [$this, 'xhrResponseDispatcher']
                );
            }

            $this->registerDefaultDrivers();

            $this->setBooted();
            //events()->trigger('field.booted', [$this]);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get(string $alias, $idOrParams = null, ?array $params = []): ?FieldDriverInterface
    {
        if (is_array($idOrParams)) {
            $params = (array)$idOrParams;
            $id = null;
        } else {
            $id = $idOrParams;
        }

        if ($id !== null && isset($this->drivers[$alias][$id])) {
            return $this->drivers[$alias][$id];
        }

        if (!$driver = $this->getDriverFromDefinition($alias)) {
            return null;
        }

        $this->drivers[$alias] = $this->drivers[$alias] ?? [];
        $index = count($this->drivers[$alias]);
        $id = $id ?? $alias . $index;
        if (!$driver->getAlias()) {
            $driver->setAlias($alias);
        }

        $params = array_merge($driver->defaultParams(), $this->config("driver.$alias", []), $params ?: []);

        $driver->setIndex($index)->setId($id)->setParams($params);
        $driver->boot();

        return $this->drivers[$alias][$id] = $driver;
    }

    /**
     * R??cup??ration d'une instance de pilote depuis une d??finition.
     *
     * @param string $alias
     *
     * @return FieldDriverInterface|null
     */
    protected function getDriverFromDefinition(string $alias): ?FieldDriverInterface
    {
        if (!$def = $this->driverDefinitions[$alias] ?? null) {
            throw new InvalidArgumentException(sprintf('Field with alias [%s] unavailable', $alias));
        }

        if ($def instanceof FieldDriverInterface) {
            return clone $def;
        }

        if (is_string($def) && $this->containerHas($def)) {
            return clone $this->containerGet($def);
        }

        if (is_string($def) && class_exists($def)) {
            return new $def($this);
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getXhrRouteUrl(string $field, ?string $controller = null, array $params = []): ?string
    {
        if ($this->xhrRoute instanceof RouteInterface && ($router = $this->router())) {
            $controller = $controller ?? 'xhrResponse';

            return $router->getRouteUrl($this->xhrRoute, array_merge($params, compact('field', 'controller')));
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function register(string $alias, $driverDefinition, ?Closure $registerCallback = null): FieldManagerInterface
    {
        /*if (isset($this->driverDefinitions[$alias])) {
            throw new RuntimeException(sprintf('Another FieldDriver with alias [%s] already registered', $alias));
        }*/

        $this->driverDefinitions[$alias] = $driverDefinition;

        if ($registerCallback !== null) {
            $registerCallback($this);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function registerDefaultDrivers(): FieldManagerInterface
    {
        foreach ($this->defaultDrivers as $alias => $driverDefinition) {
            $this->register($alias, $driverDefinition);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function xhrResponseDispatcher(string $field, string $controller, ...$args): ResponseInterface
    {
        try {
            $driver = $this->get($field);
        } catch (Exception $e) {
            throw new NotFoundException(
                sprintf('FieldDriver [%s] return exception : %s', $field, $e->getMessage()),
                'FieldDriver Error',
                $e
            );
        }

        if ($driver !== null) {
            try {
                return $driver->{$controller}(...$args);
            } catch (Exception $e) {
                throw new NotFoundException(
                    sprintf('FieldDriver [%s] Controller [%s] call return exception', $controller, $field),
                    'FieldDriver Error',
                    $e
                );
            }
        }

        throw new NotFoundException(
            sprintf('FieldDriver [%s] unreachable', $field),
            'FieldDriver Error'
        );
    }
}