<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Encryption\Encrypter;
use Pollen\Encryption\EncrypterInterface;
use Pollen\Field\FieldDriver;
use Pollen\Http\JsonResponse;
use Pollen\Http\ResponseInterface;

class PasswordJsDriver extends FieldDriver implements PasswordJsDriverInterface
{
    /**
     * Instance du contrôleur d'encryptage.
     * @var Encrypter
     */
    protected $encrypter;

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(
            parent::defaultParams(),
            [
                /**
                 *
                 */
                'ajax'      => true,
                /**
                 * @var array $container Liste des attributs de configuration du conteneur de champ.
                 */
                'container' => [
                    'attrs' => [],
                ],
                /**
                 * @var bool $hide Masquage de la valeur true (masquée)|false (visible en clair)
                 */
                'hide'      => true,
                /**
                 * @var int $length
                 */
                'length'    => 32,
                /**
                 * @var bool $readonly Activation de lecture seule (désactive aussi l'enregistrement et le générateur).
                 */
                'readonly'  => false,
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getEncrypter(): ?EncrypterInterface
    {
        if ($this->encrypter === null && $this->field()->containerHas(EncrypterInterface::class)) {
            $this->encrypter = $this->field()->containerGet(EncrypterInterface::class);
        }

        return $this->encrypter;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        if ($container_class = $this->get('container.attrs.class')) {
            $this->set('container.attrs.class', "FieldPasswordJs {$container_class}");
        } else {
            $this->set('container.attrs.class', 'FieldPasswordJs');
        }

        $options = [];
        if ($ajax = $this->get('ajax')) {
            $defaults = [
                'url'  => $this->getXhrUrl(),
                'type' => 'post',
                'data' => [],
            ];
            $options['ajax'] = is_array($ajax) ? array_merge($defaults, $ajax) : $defaults;
        }

        $this->set(
            [
                'container.attrs.aria-hidden'  => $this->get('hide') ? 'true' : 'false',
                'container.attrs.data-control' => 'password-js',
                'container.attrs.data-id'      => 'FieldPasswordJs--' . $this->getIndex(),
                'container.attrs.data-options' => $options,
            ]
        );

        $this->set(
            [
                'attrs.type' => $this->get('hide') ? 'password' : 'text',
                'attrs.size' => $this->get('attrs.size') ?: $this->get('length'),
            ]
        );

        if (!$this->has('attrs.autocomplete')) {
            $this->set('attrs.autocomplete', 'off');
        }

        if ($this->get('readonly')) {
            $this->push('attrs', 'readonly');
        }

        $this->set(
            [
                'attrs.data-control' => 'password-js.input',
                'attrs.data-cypher'  => $cypher = $this->getEncrypter()->encrypt($this->getValue()),
                'attrs.value'        => $this->get('hide') ? $cypher : $this->get('attrs.value'),
            ]
        );

        return parent::render();
    }


    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->field()->resources('/views/password-js');
    }

    /**
     * @inheritDoc
     */
    public function xhrResponse(...$args): ResponseInterface
    {
        return new JsonResponse([
            'success' => true,
            'data'    => $this->getEncrypter()->decrypt($this->httpRequest()->request->get('cypher')),
        ]);
    }
}