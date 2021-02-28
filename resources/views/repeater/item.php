<?php
/**
 * @var Pollen\Field\FieldViewLoaderInterface $this
 */
echo field('text', [
    'name'  => "{$this->getName()}[{$this->get('index')}]",
    'value' => $this->get('value'),
]);