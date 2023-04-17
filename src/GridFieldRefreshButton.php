<?php

namespace Fromholdio\GridFieldRefresh;

use SilverStripe\Forms\GridField\GridField_HTMLProvider;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;

class GridFieldRefreshButton implements GridField_HTMLProvider
{
    protected string $buttonClass;
    protected string $fragment;
    protected string $title;
    protected ?array $gridFieldReloadList;
    protected bool $doShowButton;

    public function __construct(
        ?array $gridFieldReloadList = null,
        string $title = 'Refresh',
        string $fragment = 'buttons-before-left',
        string $buttonClass = 'btn-outline-secondary',
        bool $doShowButton = true
    )
    {
        $this->setGridFieldReloadList($gridFieldReloadList);
        $this->setTitle($title);
        $this->setFragment($fragment);
        $this->setButtonClass($buttonClass);
        $this->setDoShowButton($doShowButton);
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setFragment(string $fragment): self
    {
        $this->fragment = $fragment;
        return $this;
    }

    public function getFragment(): string
    {
        return $this->fragment;
    }

    public function setButtonClass(string $class) :self
    {
        $this->buttonClass = $class;
        return $this;
    }

    public function getButtonClass() :string
    {
        return $this->buttonClass;
    }

    public function setDoShowButton(bool $value): self
    {
        $this->doShowButton = $value;
        return $this;
    }

    public function getDoShowButton(): bool
    {
        return $this->doShowButton;
    }

    public function setGridFieldReloadList(?array $list): self
    {
        $this->gridFieldReloadList = $list;
        return $this;
    }

    public function getGridFieldReloadList(): ?array
    {
        return $this->gridFieldReloadList;
    }

    public function getGridFieldReloadAttribute(): ?string
    {
        $attr = null;
        $list = $this->getGridFieldReloadList();
        if (!empty($list)) {
            $attrData = array_values($list);
            $attr = json_encode($attrData, JSON_FORCE_OBJECT);
        }
        return $attr;
    }

    public function getHTMLFragments($gridField)
    {
        Requirements::javascript('fromholdio/silverstripe-gridfield-refresh: client/js/gridfieldrefreshbutton.js');

        $data = ArrayData::create([
            'Title' => $this->getTitle(),
            'Classes' => 'action btn font-icon-sync gridfield-refresh-button ' . $this->getButtonClass(),
            'Link' => $gridField->Link(),
            'GridFieldReloadAttribute' => $this->getGridFieldReloadAttribute(),
            'DoShowButton' => $this->getDoShowButton()
        ]);
        return [$this->getFragment() => $data->renderWith(__CLASS__)];
    }

}
