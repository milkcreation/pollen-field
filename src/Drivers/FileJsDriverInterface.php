<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriverInterface;

interface FileJsDriverInterface extends FieldDriverInterface
{
    /**
     * Traitement des options du moteur de téléchargement Dropzone.
     * @see https://www.dropzonejs.com/#configuration
     *
     * @return static
     */
    public function parseDropzone(): FileJsDriverInterface;
}