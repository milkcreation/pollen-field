<?php

declare(strict_types=1);

namespace Pollen\Field;

use Pollen\View\FieldAwareViewLoader;
use Pollen\View\PartialAwareViewLoader;
use Pollen\View\ViewLoader;

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
class FieldViewLoader extends ViewLoader implements FieldViewLoaderInterface
{
    use FieldAwareViewLoader;
    use PartialAwareViewLoader;
}