<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\CheckboxCollection;

use Pollen\Field\Drivers\CheckboxDriverInterface;
use Pollen\Field\Drivers\LabelDriverInterface;
use Pollen\Support\Concerns\BuildableTrait;
use Pollen\Support\Concerns\ParamsBagDelegateTrait;
use Pollen\Support\Proxy\FieldProxy;

class CheckboxChoice implements CheckboxChoiceInterface
{
    use BuildableTrait;
    use FieldProxy;
    use ParamsBagDelegateTrait;

    /**
     * Compteur d'indice.
     * @var int
     */
    private static $_index = 0;

    /**
     * Instance de la case à cocher.
     * @var CheckboxDriverInterface
     */
    protected $checkbox;

    /**
     * Identifiant de qualification.
     * @var string
     */
    protected $id = '';

    /**
     * Indice de qualification.
     * @var int
     */
    protected $index = 0;

    /**
     * Instance de l'intitulé.
     * @var LabelDriverInterface
     */
    protected $label;

    /**
     * Instance du gestionnaire d'affichage de la liste des éléments.
     * @var CheckboxChoicesInterface
     */
    protected $choices;

    /**
     * @param string $id Identifiant de qualification.
     * @param array|string|CheckboxDriverInterface $checkboxDef
     *
     * @return void
     */
    public function __construct(string $id, $checkboxDef)
    {
        $this->id = $id;
        $this->index = self::$_index++;

        if (is_string($checkboxDef)) {
            $checkboxDef = [
                'label' => [
                    'content' => $checkboxDef,
                ],
            ];
        }

        if ($checkboxDef instanceof CheckboxDriverInterface) {
            $this->checkbox = $checkboxDef;
        } else {
            $this->set(array_merge($this->defaults(), $checkboxDef));
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
    public function build(): CheckboxChoiceInterface
    {
        if (!$this->isBuilt()) {
            $this->parse();

            $this->setBuilt();
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function defaults(): array
    {
        return [
            'label'    => [
                'before'  => '',
                'after'   => '',
                'content' => '',
                'attrs'   => [],
            ],
            'checkbox' => [
                'before'  => '',
                'after'   => '',
                'attrs'   => [],
                'name'    => '',
                'value'   => '',
                'checked' => $this->id,
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getCheckbox(): CheckboxDriverInterface
    {
        return $this->checkbox;
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getLabel(): LabelDriverInterface
    {
        return $this->label;
    }

    /**
     * @inheritDoc
     */
    public function getNameAttr(): string
    {
        return $this->getCheckbox() instanceof CheckboxDriverInterface ? $this->getCheckbox()->getName() : '';
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->getCheckbox() instanceof CheckboxDriverInterface ? $this->getCheckbox()->getValue() : null;
    }

    /**
     * @inheritDoc
     */
    public function isChecked(): bool
    {
        return $this->getCheckbox() instanceof CheckboxDriverInterface ? $this->getCheckbox()->isChecked() : false;
    }

    /**
     * @inheritDoc
     */
    public function parse(): void
    {
        if (!$this->get('attrs.id')) {
            $this->set('attrs.id', 'FieldCheckboxCollection-item--' . $this->index);
        }

        if (!$this->get('checkbox.attrs.id')) {
            $this->set('checkbox.attrs.id', 'FieldCheckboxCollection-itemInput--' . $this->index);
        }

        if (!$this->get('checkbox.attrs.class')) {
            $this->set('checkbox.attrs.class', 'FieldCheckboxCollection-itemInput');
        }

        if (!$this->get('label.attrs.id')) {
            $this->set('label.attrs.id', 'FieldCheckboxCollection-itemLabel--' . $this->index);
        }

        if (!$this->get('label.attrs.class')) {
            $this->set('label.attrs.class', 'FieldCheckboxCollection-itemLabel');
        }

        if (!$this->get('label.attrs.for')) {
            $this->set('label.attrs.for', 'FieldCheckboxCollection-itemInput--' . $this->index);
        }

        $this->checkbox = $this->field()->get('checkbox', $this->get('checkbox', []));
        $this->label = $this->field()->get('label', $this->get('label', []));
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        return $this->getCheckbox()->render() . $this->getLabel()->render();
    }

    /**
     * @inheritDoc
     */
    public function setNameAttr(string $name): CheckboxChoiceInterface
    {
        if ($this->getCheckbox() instanceof CheckboxDriverInterface) {
            $this->getCheckbox()->set('attrs.name', $name);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setChecked(): CheckboxChoiceInterface
    {
        if ($this->getCheckbox() instanceof CheckboxDriverInterface) {
            $this->getCheckbox()->push('attrs', 'checked');
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setChoices(CheckboxChoicesInterface $choices): CheckboxChoiceInterface
    {
        $this->choices = $choices;

        return $this;
    }
}