<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\CheckboxCollection;

use Illuminate\Support\Collection;
use Pollen\Field\Drivers\CheckboxCollectionDriverInterface;
use Pollen\Support\Arr;

class CheckboxWalker implements CheckboxWalkerInterface
{
    /**
     * Indicateur d'initialisation.
     * @var bool
     */
    private $built = false;

    /**
     * Instance du champ associé.
     * @var CheckboxCollectionDriverInterface
     */
    protected $field;

    /**
     * Liste des éléments.
     * @var CheckboxChoice[]
     */
    protected $items = [];

    /**
     * CONSTRUCTEUR.
     *
     * @param array $items Liste des éléments
     */
    public function __construct(array $items)
    {
        foreach($items as $key => $item) {
            $this->setItem($item, $key);
        }
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * @inheritDoc
     */
    public function build(): CheckboxWalkerInterface
    {
        if (!$this->built) {
            if ($this->exists()) {
                foreach ($this->items as $item) {
                    $item->setWalker($this)->build()->setNameAttr($this->field->getName());
                }

                $this->registerChecked();
            }

            $this->built = true;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function exists(): bool
    {
        return (bool)$this->items;
    }

    /**
     * @inheritDoc
     */
    public function registerChecked(): CheckboxWalkerInterface
    {
        $checked = $this->field->getValue();
        $collect = new Collection($this->items);

        if ($checked !== null) {
            $checked = Arr::wrap($checked);

            $collect->each(
                function (CheckboxChoice $item) use ($checked) {
                    if (in_array($item->getCheckbox()->get('checked'), $checked, true)) {
                        $item->setChecked();
                    }
                }
            );
        } elseif ($default = $this->field->get('default')) {
            if ($default === true) {
                if (!$collect->first(function (CheckboxChoice $item) { return $item->isChecked(); })) {
                    if ($first = $collect->first()) {
                        $first->setChecked();
                    }
                }
            } else {
                $default = Arr::wrap($default);

                $collect->each(
                    function (CheckboxChoice $item) use ($default) {
                        if (in_array($item->getCheckbox()->get('checked'), $default, true)) {
                            $item->setChecked();
                        }
                    }
                );
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        return $this->field->view('choices', ['items' => $this->items]);
    }

    /**
     * @inheritDoc
     */
    public function setField(CheckboxCollectionDriverInterface $field): CheckboxWalkerInterface
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setItem($item, $key = null): CheckboxChoiceInterface
    {
        if (!$item instanceof CheckboxChoiceInterface) {
            $item = new CheckboxChoice($key, $item);
        }

        return $this->items[$key] = $item;
    }
}