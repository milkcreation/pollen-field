<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\RadioCollection;

use Illuminate\Support\Collection;
use Pollen\Field\Drivers\RadioCollectionDriverInterface;
use Pollen\Support\Arr;

class RadioWalker implements RadioWalkerInterface
{
    /**
     * Indicateur d'initialisation.
     * @var bool
     */
    private $built = false;

    /**
     * Instance du champ associé.
     * @var RadioCollectionDriverInterface
     */
    protected $field;

    /**
     * Liste des éléments.
     * @var RadioChoice[]
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
    public function build(): RadioWalkerInterface
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
    public function registerChecked(): RadioWalkerInterface
    {
        $checked = $this->field->getValue();
        $collect = new Collection($this->items);

        if ($checked !== null) {
            $checked = Arr::wrap($checked);

            $collect->each(
                function (RadioChoice $item) use ($checked) {
                    if (in_array($item->getRadio()->get('checked'), $checked, true)) {
                        $item->setChecked();
                    }
                }
            );
        } elseif ($default = $this->field->get('default')) {
            if ($default === true) {
                if (!$collect->first(function (RadioChoice $item) { return $item->isChecked(); })) {
                    if ($first = $collect->first()) {
                        $first->setChecked();
                    }
                }
            } else {
                $default = Arr::wrap($default);

                $collect->each(
                    function (RadioChoice $item) use ($default) {
                        if (in_array($item->getRadio()->get('checked'), $default, true)) {
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
    public function setField(RadioCollectionDriverInterface $field): RadioWalkerInterface
    {
        if (!$this->field instanceof RadioCollectionDriverInterface) {
            $this->field = $field;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setItem($item, $key): RadioChoiceInterface
    {
        if (!$item instanceof RadioChoiceInterface) {
            $item = new RadioChoice($key, $item);
        }

        return $this->items[$key] = $item;
    }
}