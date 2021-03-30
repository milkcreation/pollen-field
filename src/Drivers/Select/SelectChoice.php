<?php

declare(strict_types=1);

namespace Pollen\Field\Drivers\Select;

use Pollen\Support\Html;
use Pollen\Support\ParamsBag;

class SelectChoice extends ParamsBag implements SelectChoiceInterface
{
    /**
     * Nom de qualification.
     * @var int|string
     */
    protected $name = '';

    /**
     * Niveau de profondeur d'affichage dans le selecteur.
     * @var int
     */
    private $depth = 0;

    /**
     * CONSTRUCTEUR.
     *
     * @param string $name Nom de qualification de l'élément.
     * @param array|string $attrs Liste des attributs de configuration|Intitulé de qualification de l'option.
     *
     * @return void
     */
    public function __construct(string $name, $attrs = [])
    {
        $this->name = $name;
        $this->set($attrs);

        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    public function defaults(): array
    {
        return [
            'name'    => $this->name,
            'group'   => false,
            'attrs'   => [],
            'parent'  => null,
            'value'   => $this->name,
            'content' => '',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getContent(): string
    {
        return (string)$this->get('content');
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return (string)$this->get('name');
    }

    /**
     * @inheritdoc
     */
    public function getValue(): string
    {
        return (string)$this->get('value');
    }

    /**
     * @inheritdoc
     */
    public function getParent(): ?string
    {
        return $this->get('parent', null);
    }

    /**
     * @inheritdoc
     */
    public function hasParent(): bool
    {
        return $this->get('parent') !== null;
    }

    /**
     * @inheritdoc
     */
    public function isDisabled(): bool
    {
        return in_array('disabled', $this->get('attrs', []), true);
    }

    /**
     * @inheritdoc
     */
    public function isGroup(): bool
    {
        return $this->get('group');
    }

    /**
     * @inheritdoc
     */
    public function isSelected(): bool
    {
        return !$this->isGroup() && in_array('selected', $this->get('attrs', []), true);
    }

    /**
     * @inheritdoc
     */
    public function setDepth(int $depth = 0): SelectChoiceInterface
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setSelected(array $selected): SelectChoiceInterface
    {
        if ($selected !== null) {
            if (!$this->isGroup() && in_array($this->getValue(), $selected, true)) {
                $this->push('attrs', 'selected');
            }
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function parse(): void
    {
        parent::parse();

        if ($this->isGroup()) {
            $this->pull('value');
            $this->set(
                'attrs.label',
                str_repeat("&nbsp;&nbsp;&nbsp;", $this->depth) . htmlentities($this->pull('content'))
            );
        } else {
            $this->set('attrs.value', $this->getValue());
        }
    }

    /**
     * @inheritdoc
     */
    public function tagClose(): string
    {
        return $this->isGroup() ? "\n" . str_repeat("\t", $this->depth) . "</optgroup>" : "</option>";
    }

    /**
     * @inheritdoc
     */
    public function tagContent(): string
    {
        return $this->getContent() ? : '';
    }

    /**
     * @inheritdoc
     */
    public function tagOpen(): string
    {
        $attrs = Html::attr($this->get('attrs', []));

        return "\n" . str_repeat("\t", $this->depth) . ($this->isGroup() ? "<optgroup {$attrs}>" : "<option {$attrs}>");
    }
}