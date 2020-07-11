<?php

namespace Systemattic\LivewireSort\Contracts;

interface Sortable
{
    /**
     * Handles Sorting Event
     *
     * @param array|mixed $event
     **/
    public function sorting($event);
}
