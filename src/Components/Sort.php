<?php

namespace Systemattic\LivewireSort\Components;

use Livewire\Component;

class Sort extends Component
{
    public string $field;

    public string $label;

    public ?bool $asc;

    public function mount(string $field, string $label, ?bool $asc = null)
    {
        $this->field = $field;

        $this->label = $label;

        $this->asc = $asc;

        $this->emitSortingEvent();
    }

    public function sort()
    {
        $this->asc = !$this->asc;

        $this->emitSortingEvent();
    }

    public function render()
    {
        return view('livewire-sort::sort');
    }

    private function emitSortingEvent()
    {
        $this->emit('sorting', [
            'direction' => $this->getSortDirection(),
            'field' => $this->field,
        ]);
    }

    public function getSortDirection()
    {
        if (is_null($this->asc)) {
            return null;
        }

        return $this->asc ? 'asc' : 'desc';
    }
}
