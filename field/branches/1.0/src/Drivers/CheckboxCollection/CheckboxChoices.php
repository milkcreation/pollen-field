<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\CheckboxCollection;

use Illuminate\Support\Collection;
use Pollen\Field\Drivers\CheckboxCollectionDriverInterface;
use Pollen\Support\Concerns\BuildableTrait;

class CheckboxChoices implements CheckboxChoicesInterface
{
    use BuildableTrait;

    /**
     * Instance du champ de collection de cases à cocher associé.
     * @var CheckboxCollectionDriverInterface
     */
    protected $checkboxCollection;

    /**
     * Liste des éléments.
     * @var CheckboxChoice[]
     */
    protected $choices = [];

    /**
     * @param array $choices
     */
    public function __construct(array $choices)
    {
        foreach($choices as $key => $choiceDef) {
            $this->setChoice((string)$key, $choiceDef);
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
    public function build(): CheckboxChoicesInterface
    {
        if (!$this->isBuilt()) {
            if ($this->exists()) {
                foreach ($this->choices as $choice) {
                    $choice->setChoices($this)->build()->setNameAttr($this->checkboxCollection->getName());
                }

                $this->registerChecked();
            }

            $this->setBuilt();
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function exists(): bool
    {
        return (bool)$this->choices;
    }

    /**
     * @inheritDoc
     */
    public function registerChecked(): CheckboxChoicesInterface
    {
        $checked = $this->checkboxCollection->getValue();
        $collect = new Collection($this->choices);

        if ($checked) {
            $collect->each(
                function (CheckboxChoice $choice) use ($checked) {
                    if (in_array($choice->getCheckbox()->get('checked'), $checked, true)) {
                        $choice->setChecked();
                    }
                }
            );
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        return $this->checkboxCollection->view('choices', ['choices' => $this->choices]);
    }

    /**
     * @inheritDoc
     */
    public function setCheckboxCollection(CheckboxCollectionDriverInterface $checkboxCollection): CheckboxChoicesInterface
    {
        $this->checkboxCollection = $checkboxCollection;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setChoice(string $key, $choiceDef): CheckboxChoiceInterface
    {
        $choice = ($choiceDef instanceof CheckboxChoiceInterface) ? $choiceDef : new CheckboxChoice($key, $choiceDef);

        return $this->choices[$key] = $choice;
    }
}