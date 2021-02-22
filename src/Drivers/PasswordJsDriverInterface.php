<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Encryption\EncrypterInterface;
use Pollen\Field\FieldDriverInterface;

interface PasswordJsDriverInterface extends FieldDriverInterface
{
    /**
     * Récupération du gestionnaire de cryptage.
     *
     * @return EncrypterInterface|null
     */
    public function getEncrypter(): ?EncrypterInterface;
}