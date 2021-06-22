<?php
/**
 * @var Pollen\Field\FieldTemplate $this
 */
echo $this->field('text', [
    'name'  => "{$this->getName()}[{$this->get('index')}]",
    'value' => $this->get('value'),
]);