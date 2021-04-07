<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\RadioCollection;

use Illuminate\Support\Collection;
use Pollen\Field\Drivers\RadioCollectionDriverInterface;
use Pollen\Support\Concerns\BuildableTrait;

class RadioChoices implements RadioChoicesInterface
{
    use BuildableTrait;

    /**
     * Instance du champ de collection de boutons radio associé.
     * @var RadioCollectionDriverInterface
     */
    protected $radioCollection;

    /**
     * Liste des éléments.
     * @var RadioChoice[]
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
    public function build(): RadioChoicesInterface
    {
        if (!$this->isBuilt()) {
            if ($this->exists()) {
                foreach ($this->choices as $choice) {
                    $choice->setChoices($this)->build()->setNameAttr($this->radioCollection->getName());
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
    public function registerChecked(): RadioChoicesInterface
    {
        $checked = $this->radioCollection->getValue();
        $collect = new Collection($this->choices);

        if ($checked) {
            $collect->each(
                function (RadioChoice $choice) use ($checked) {
                    if ($choice->getRadio()->get('checked') === $checked) {
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
        return $this->radioCollection->view('choices', ['choices' => $this->choices]);
    }

    /**
     * @inheritDoc
     */
    public function setRadioCollection(RadioCollectionDriverInterface $radioCollection): RadioChoicesInterface
    {
        $this->radioCollection = $radioCollection;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setChoice(string $key, $choiceDef): RadioChoiceInterface
    {
        $choice = ($choiceDef instanceof RadioChoiceInterface) ? $choiceDef : new RadioChoice($key, $choiceDef);

        return $this->choices[$key] = $choice;
    }
}