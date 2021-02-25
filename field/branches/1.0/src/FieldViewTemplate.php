<?php

declare(strict_types=1);

namespace Pollen\Field;

use Pollen\View\ViewTemplate;
use RuntimeException;

/**
 * @method string after()
 * @method string attrs()
 * @method string before()
 * @method string content()
 * @method string getAlias()
 * @method string getId()
 * @method string getIndex()
 * @method string getName()
 * @method string getValue()
 */
class FieldViewTemplate extends ViewTemplate implements FieldViewTemplateInterface
{
    /**
     * Récupération de l'instance de délégation.
     *
     * @return FieldDriverInterface
     */
    protected function getDelegate(): FieldDriverInterface
    {
        /** @var FieldDriverInterface|object|null $delegate */
        $delegate = $this->engine->getDelegate();
        if ($delegate instanceof FieldDriverInterface) {
            return $delegate;
        }

        throw new RuntimeException('FieldViewTemplate must have a delegate FieldDriver instance');
    }

    /**
     * @inheritDoc
     */
    public function field(string $alias, $idOrParams = null, array $params = []): string
    {
        $manager = $this->getDelegate()->fieldManager();

        return (string)$manager->get($alias, $idOrParams, $params);
    }

    /**
     * @inheritDoc
     */
    public function partial(string $alias, $idOrParams = null, array $params = []): string
    {
        $manager = $this->getDelegate()->partialManager();

        return (string)$manager->get($alias, $idOrParams, $params);
    }
}