<?php

declare(strict_types=1);

namespace Pollen\Field;

use Closure;
use InvalidArgumentException;
use Pollen\Http\JsonResponse;
use Pollen\Http\ResponseInterface;
use Pollen\Support\Concerns\BootableTrait;
use Pollen\Support\Concerns\ParamsBagDelegateTrait;
use Pollen\Support\Proxy\FieldProxy;
use Pollen\Support\Proxy\HttpRequestProxy;
use Pollen\Support\Proxy\PartialProxy;
use Pollen\Support\Html;
use Pollen\Support\Proxy\ViewProxy;
use Pollen\Support\Str;
use Pollen\View\ViewInterface;

abstract class FieldDriver implements FieldDriverInterface
{
    use BootableTrait;
    use FieldProxy;
    use HttpRequestProxy;
    use PartialProxy;
    use ParamsBagDelegateTrait;
    use ViewProxy;

    /**
     * Indice de l'instance dans le gestionnaire.
     */
    private int $index = 0;

    /**
     * Alias de qualification.
     */
    protected string $alias = '';

    /**
     * Liste des attributs par défaut.
     */
    protected static array $defaults = [];

    /**
     * Identifiant de qualification.
     * {@internal par défaut concaténation de l'alias et de l'indice.}
     */
    protected string $id = '';

    /**
     * Template view instance.
     */
    protected ?ViewInterface $view = null;

    /**
     * @param FieldManagerInterface $fieldManager
     */
    public function __construct(FieldManagerInterface $fieldManager)
    {
        $this->setFieldManager($fieldManager);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * @inheritDoc
     */
    public function after(): void
    {
        echo ($after = $this->get('after')) instanceof Closure ? $after($this) : $after;
    }

    /**
     * @inheritDoc
     */
    public function attrs(): void
    {
        echo Html::attr($this->get('attrs', []));
    }

    /**
     * @inheritDoc
     */
    public function before(): void
    {
        echo ($before = $this->get('before')) instanceof Closure ? $before($this) : $before;
    }

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if (!$this->isBooted()) {
            //events()->trigger('field.driver.booting', [$this->getAlias(), $this]);

            $this->parseParams();

            $this->setBooted();
            //events()->trigger('field.driver.booted', [$this->getAlias(), $this]);
        }
    }

    /**
     * @inheritDoc
     */
    public function content(): void
    {
        echo ($content = $this->get('content')) instanceof Closure ? $content($this) : $content;
    }

    /**
     * @inheritDoc
     *
     * @return array
     */
    public function defaultParams(): array
    {
        return array_merge(
            static::$defaults,
            [
                /**
                 * @var array $attrs Attributs HTML du champ.
                 */
                'attrs'  => [],
                /**
                 * @var string $after Contenu placé après le champ.
                 */
                'after'  => '',
                /**
                 * @var string $before Contenu placé avant le champ.
                 */
                'before' => '',
                /**
                 * @var string|null $name Nom de qualification de la requête HTTP de soumission du formulaire.
                 */
                'name'   => null,
                /**
                 * @var string|null $value Valeur courante|Issue de la requête HTTP de soumission du formulaire.
                 */
                'value'  => null,
                /**
                 * @var array $viewer Liste des attributs de configuration du pilote d'affichage.
                 */
                'viewer' => [],
                /**
                 * @var Closure|array|string|null
                 */
                'render' => null,
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @inheritDoc
     */
    public function getBaseClass(): string
    {
        return 'Field' . Str::studly($this->getAlias());
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->get('attrs.name');
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->get('attrs.value');
    }

    /**
     * @inheritDoc
     */
    public function getXhrUrl(array $params = [], ?string $controller = null): string
    {
        return $this->field()->getXhrRouteUrl($this->getAlias(), $controller, $params);
    }

    /**
     * @inheritDoc
     */
    public function parseParams(): void
    {
        $this->parseAttrId()->parseAttrClass()->parseAttrName()->parseAttrValue();
    }

    /**
     * @inheritDoc
     */
    public function parseAttrClass(): FieldDriverInterface
    {
        $base = $this->getBaseClass();

        $default_class = "$base $base--" . $this->getIndex();
        if (!$this->has('attrs.class')) {
            $this->set('attrs.class', $default_class);
        } else {
            $this->set('attrs.class', sprintf($this->get('attrs.class'), $default_class));
        }

        if (!$this->get('attrs.class')) {
            $this->forget('attrs.class');
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function parseAttrId(): FieldDriverInterface
    {
        if (!$this->get('attrs.id')) {
            $this->forget('attrs.id');
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function parseAttrName(): FieldDriverInterface
    {
        if ($name = $this->pull('name')) {
            $this->set('attrs.name', $name);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function parseAttrValue(): FieldDriverInterface
    {
        $value = $this->pull('value')?? $this->get('attrs.value');

        $this->set('attrs.value', $value !== null ? (string)$value : null);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        return $this->view('index', $this->all());
    }

    /**
     * @inheritDoc
     */
    public function setAlias(string $alias): FieldDriverInterface
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public static function setDefaults(array $defaults = []): void
    {
        static::$defaults = $defaults;
    }

    /**
     * @inheritDoc
     */
    public function setId(string $id): FieldDriverInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setIndex(int $index): FieldDriverInterface
    {
        $this->index = $index;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function view(?string $name = null, array $data = [])
    {
        if ($this->view === null) {
            $default = $this->field()->config('default.driver.viewer', []);

            $directory = $this->get('viewer.directory');
            if ($directory && !file_exists($directory)) {
                $directory = null;
            }

            $overrideDir = $this->get('viewer.override_dir');
            if ($overrideDir && !file_exists($overrideDir)) {
                $overrideDir = null;
            }

            if ($directory === null && isset($default['directory'])) {
                $default['directory'] = rtrim($default['directory'], '/') . '/' . $this->getAlias();
                if (file_exists($default['directory'])) {
                    $directory = $default['directory'];
                }
            }

            if ($overrideDir === null && isset($default['override_dir'])) {
                $default['override_dir'] = rtrim($default['override_dir'], '/') . '/' . $this->getAlias();
                if (file_exists($default['override_dir'])) {
                    $overrideDir = $default['override_dir'];
                }
            }

            if ($directory === null) {
                $directory = $this->viewDirectory();
                if (!file_exists($directory)) {
                    throw new InvalidArgumentException(
                        sprintf('Field [%s] must have an accessible view directory', $this->getAlias())
                    );
                }
            }

            $this->view = $this->viewManager()->createView('plates')
                ->setDirectory($directory);

            if ($overrideDir !== null) {
                $this->view->setOverrideDir($overrideDir);
            }

            $functions = [
                'after',
                'attrs',
                'before',
                'content',
                'getAlias',
                'getId',
                'getIndex',
                'getName',
                'getValue',
            ];
            foreach ($functions as $fn) {
                $this->view->addExtension($fn, [$this, $fn]);
            }
        }

        if (func_num_args() === 0) {
            return $this->view;
        }

        return $this->view->render($name, $data);
    }

    /**
     * @inheritDoc
     */
    abstract public function viewDirectory(): string;

    /**
     * @inheritDoc
     */
    public function xhrResponse(...$args): ResponseInterface
    {
        return new JsonResponse(
            [
                'success' => true,
            ]
        );
    }
}