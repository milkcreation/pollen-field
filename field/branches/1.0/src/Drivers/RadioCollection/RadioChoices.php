<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\RadioCollection;

use Pollen\Field\Drivers\RadioCollectionDriverInterface;
use Pollen\Support\Concerns\BuildableTrait;

class RadioChoices implements RadioChoicesInterface
{
    use BuildableTrait;

    /**
     * Instance du champ de collection de boutons radio associé.
     * @var RadioCollectionDriverInterface
     */
    protected $collector;

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
            if (!empty($this->choices)) {
                foreach ($this->choices as $choice) {
                    $choice->setChoices($this)->build();
                }
            }

            $this->setBuilt();
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function collector(): ?RadioCollectionDriverInterface
    {
        return $this->collector;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        return $this->collector->view('choices', ['choices' => $this->choices]);
    }

    /**
     * @inheritDoc
     */
    public function setCollector(RadioCollectionDriverInterface $collector): RadioChoicesInterface
    {
        $this->collector = $collector;

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