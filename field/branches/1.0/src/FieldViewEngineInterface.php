<?php

declare(strict_types=1);

namespace Pollen\Field;

use Pollen\View\ViewEngineInterface;
use Pollen\View\ViewTemplateInterface;

interface FieldViewEngineInterface extends ViewEngineInterface
{
    /**
     * {@inheritDoc}
     *
     * @return FieldViewTemplate
     */
    public function make($name): ViewTemplateInterface;
}