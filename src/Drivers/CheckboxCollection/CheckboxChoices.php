<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\CheckboxCollection;

use Pollen\Field\Drivers\CheckboxCollectionDriverInterface;
use Pollen\Support\Concerns\BuildableTrait;

class CheckboxChoices implements CheckboxChoicesInterface
{
    use BuildableTrait;

    /**
     * Instance du champ de collection de cases à cocher associé.
     * @var CheckboxCollectionDriverInterface
     */
    protected $collector;

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
    public function collector(): ?CheckboxCollectionDriverInterface
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
    public function setCollector(CheckboxCollectionDriverInterface $collector): CheckboxChoicesInterface
    {
        $this->collector = $collector;

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