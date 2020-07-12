<?php

namespace Systemattic\LivewireSort\Traits;

use ReflectionMethod;
use ReflectionProperty;
use Systemattic\LivewireSort\Exceptions\SortingPropertiesNotSet;

trait WithSorting
{
    public function initializeWithSorting()
    {
        $this->confirmSortingEventListening();

        $sortField = config('livewire_sort.sort_field_property_name');
        $sortDirection = config('livewire_sort.sort_direction_property_name');

        $this->confirmPropExists($sortField);
        $this->confirmPropExists($sortDirection);

        if (is_null($this->{$sortField})) {
            $this->{$sortField} = config('livewire_sort.initial_sort_field');
        }

        if (is_null($this->{$sortDirection})) {
            $this->{$sortDirection} = config('livewire_sort.initial_sort_direction');
        }
    }

    public function sorting($event)
    {
        $sortField = config('livewire_sort.sort_field_property_name');

        $sortDirection = config('livewire_sort.sort_direction_property_name');

        $this->{$sortField} = $event['field'];

        $this->{$sortDirection} = $event['direction'];
    }

    private function confirmPropExists($prop)
    {
        if (!property_exists($this, $prop)) {
            throw new SortingPropertiesNotSet("The Component must have the public property [{$prop}]");
        }

        $refProp = new ReflectionProperty($this, $prop);

        if (!$refProp->isPublic()) {
            throw new SortingPropertiesNotSet("[$prop] must be a public property of the component");
        }
    }

    private function confirmSortingEventListening()
    {
        $listensForEvent = array_key_exists('sorting', $this->listeners ?? [])
            || array_key_exists('sorting', $this->getListeners() ?? []);


        if ($listensForEvent && !($this->listeners['sorting'] == 'sorting' || @$this->getListeners()['sorting'] == 'sorting')) {

            throw new \Exception(
                "Handler for sorting event not set, define a [listeners] property or [getListeners] method to handle the [sorting] event"
            );
        }

        $mapsListenerToHandler = in_array('sorting', $this->listeners ?? [])
            || in_array('sorting', $this->getListeners() ?? []);


        if (!($listensForEvent || $mapsListenerToHandler)) {

            throw new \Exception(
                "Handler for sorting event not set, define a [listeners] property or [getListeners] method to handle the [sorting] event"
            );
        }

        $refProp = new ReflectionProperty($this, 'listeners');

        if (!$refProp->isProtected()) {

            throw new \Exception(
                "[listeners] must be a protected property of the component for event listening to occur!!"
            );
        }

        $refMtd = new ReflectionMethod($this, 'getListeners');

        if (!$refMtd->isProtected()) {

            throw new \Exception(
                "[getListeners] must be a protected method of the component for event listening to occur!!"
            );
        }
    }
}
