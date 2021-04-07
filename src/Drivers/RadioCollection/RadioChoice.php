<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\RadioCollection;

use Pollen\Field\Drivers\LabelDriverInterface;
use Pollen\Field\Drivers\RadioDriverInterface;
use Pollen\Support\Concerns\BuildableTrait;
use Pollen\Support\Concerns\ParamsBagDelegateTrait;
use Pollen\Support\Proxy\FieldProxy;

class RadioChoice implements RadioChoiceInterface
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
     * Nom de qualification.
     * @var string|int
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
     * Instance du bouton radio.
     * @var RadioDriverInterface
     */
    protected $radio;

    /**
     * Instance du gestionnaire d'affichage de la liste des éléments.
     * @var RadioChoicesInterface
     */
    protected $choices;

    /**
     * @param string $id Identifiant de qualification.
     * @param array|string|RadioDriverInterface $radioDef
     *
     * @return void
     */
    public function __construct(string $id, $radioDef)
    {
        $this->id = $id;
        $this->index = self::$_index++;

        if (is_string($radioDef)) {
            $radioDef = [
                'label' => [
                    'content' => $radioDef,
                ],
            ];
        }

        if ($radioDef instanceof RadioDriverInterface) {
            $this->radio = $radioDef;
        } else {
            $this->set(array_merge($this->defaults(), $radioDef));
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
    public function build(): RadioChoiceInterface
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
            'label' => [
                'before'  => '',
                'after'   => '',
                'content' => '',
                'attrs'   => [],
            ],
            'radio' => [
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
        return $this->getRadio() instanceof RadioDriverInterface ? $this->getRadio()->getName() : '';
    }

    /**
     * @inheritDoc
     */
    public function getRadio(): RadioDriverInterface
    {
        return $this->radio;
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->getRadio() instanceof RadioDriverInterface ? $this->getRadio()->getValue() : null;
    }

    /**
     * @inheritDoc
     */
    public function isChecked(): bool
    {
        return $this->getRadio() instanceof RadioDriverInterface ? $this->getRadio()->isChecked() : false;
    }

    /**
     * @inheritDoc
     */
    public function parse(): void
    {
        if (!$this->get('attrs.id')) {
            $this->set('attrs.id', 'FieldRadioCollection-item--' . $this->index);
        }

        if (!$this->get('radio.attrs.id')) {
            $this->set('radio.attrs.id', 'FieldRadioCollection-itemInput--' . $this->index);
        }

        if (!$this->get('radio.attrs.class')) {
            $this->set('radio.attrs.class', 'FieldRadioCollection-itemInput');
        }

        if (!$this->get('label.attrs.id')) {
            $this->set('label.attrs.id', 'FieldRadioCollection-itemLabel--' . $this->index);
        }

        if (!$this->get('label.attrs.class')) {
            $this->set('label.attrs.class', 'FieldRadioCollection-itemLabel');
        }

        if (!$this->get('label.attrs.for')) {
            $this->set('label.attrs.for', 'FieldRadioCollection-itemInput--' . $this->index);
        }

        $this->radio = $this->field()->get('radio', $this->get('radio', []));
        $this->label = $this->field()->get('label', $this->get('label', []));
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        return $this->getRadio()->render() . $this->getLabel()->render();
    }

    /**
     * @inheritDoc
     */
    public function setNameAttr(string $name): RadioChoiceInterface
    {
        if ($this->getRadio() instanceof RadioDriverInterface) {
            $this->getRadio()->set('attrs.name', $name);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setChecked(): RadioChoiceInterface
    {
        if ($this->getRadio() instanceof RadioDriverInterface) {
            $this->getRadio()->push('attrs', 'checked');
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setChoices(RadioChoicesInterface $choices): RadioChoiceInterface
    {
        $this->choices = $choices;

        return $this;
    }
}