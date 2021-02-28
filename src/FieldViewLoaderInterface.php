<?php

declare(strict_types=1);

namespace Pollen\Field;

use Pollen\View\FieldAwareViewLoaderInterface;
use Pollen\View\PartialAwareViewLoaderInterface;
use Pollen\View\ViewLoaderInterface;

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
interface FieldViewLoaderInterface extends
    FieldAwareViewLoaderInterface,
    PartialAwareViewLoaderInterface,
    ViewLoaderInterface
{
}