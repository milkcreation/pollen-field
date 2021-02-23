<?php
/**
 * @var Pollen\Field\FieldViewTemplateInterface $this
 */
echo field('text', [
    'name'  => "{$this->getName()}[{$this->get('index')}]",
    'value' => $this->get('value'),
]);