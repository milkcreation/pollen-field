<?php

declare(strict_types=1);

namespace Pollen\Field;

use Pollen\View\ViewEngine;
use Pollen\View\ViewTemplateInterface;

class FieldViewEngine extends ViewEngine implements FieldViewEngineInterface
{
    /**
     * Liste des méthodes de délégations permises.
     * @var array
     */
    protected $delegatedMixins = [
        'after',
        'attrs',
        'before',
        'content',
        'getAlias',
        'getId',
        'getIndex',
    ];

    /**
     * {@inheritDoc}
     *
     * @return FieldViewTemplateInterface
     */
    public function make($name): ViewTemplateInterface
    {
        return new FieldViewTemplate($this, $name);
    }
}