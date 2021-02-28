<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers;

use Pollen\Field\FieldDriver;

class TinymceDriver extends FieldDriver implements TinymceDriverInterface
{
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
                'tag'     => 'textarea',
                /**
                 *
                 */
                'options' => [],
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $options = array_merge(
            [
                'content_css' => [],
                'skin'        => false,
            ],
            $this->get('options', [])
        );

        $this->set(
            [
                'attrs.data-control' => 'tinymce',
                'attrs.data-options' => $options,
            ]
        );
        $this->pull('attrs.value');

        return parent::render();
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->field()->resources('/views/tinymce');
    }
}