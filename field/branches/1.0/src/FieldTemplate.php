<?php

declare(strict_types=1);

namespace Pollen\Field;

use Pollen\View\Engines\Plates\PlatesFieldAwareTemplateTrait;
use Pollen\View\Engines\Plates\PlatesPartialAwareTemplateTrait;
use Pollen\View\Engines\Plates\PlatesTemplate;

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
class FieldTemplate extends PlatesTemplate
{
    use PlatesFieldAwareTemplateTrait;
    use PlatesPartialAwareTemplateTrait;
}