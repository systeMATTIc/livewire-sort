# Livewire Sort

> This package is for a demonstration and does not have a test suite.

A Livewire component for handling sorting on data driven tables in livewire components.

## Example

[Livewire Sort Example Repository](https://github.com/systeMATTIc/livewire-sort-example)

## Installation

Since this is a private demo, public installation via composer has not been setup. To use,

- Clone the repository

- Add the path to the package in the repository key of your laravel project's `composer.json` file.

```json
{
  "scripts": { ... },

  "repositories": [
    {
      "type": "path",
      "url": "relative/path/to/package"
    }
  ]
}
```

- From your project's root folder, run

```bash
composer require systemattic/livewire-sort
```

## Usage

This is to be used in a livewire powered table component.

For the table component's class,

```php
<?php

namespace App\Http\Livewire;

use App\User;
use Livewire\Component;
use Systemattic\LivewireSort\Traits\WithSorting;

class UsersTable extends Component
{
    use WithSorting;

    public $sortField;

    public $sortDirection;

    protected $listeners = ['sorting'];

    public function render()
    {
        return view('livewire.users-table', [
            'users' => User::orderBy($this->sortField, $this->sortDirection)->get()
        ]);
    }
}
```

The table component must provide have two properties, and use the `WithSorting` trait.

```php
public $sortField;

public $sortDirection;
```

The Sort Component emits a sorting event, therefore the table component must defined a listeners array for the event. The `WithSorting` trait automatically handles the sorting event.

You may define the listener array on the component as follows

```php
protected $listeners = ['sorting'];
```

or

```php
protected $listeners = ['sorting' => 'sorting'];
```

or

```php
protected function getListeners()
{
    return ['sorting'];
}
```

or

```php
protected function getListeners()
{
    return ['sorting' => 'sorting'];
}
```

For the table component's view,

```html
...
<thead>
  <tr>
    <th class="pr-4">
      @livewire('sort', ['field' => 'first_name', 'label' => 'First Name'])
    </th>

    <th class="px-4 py-2">
      @livewire('sort', ['field' => 'last_name', 'label' => 'Last Name'])
    </th>

    <th class="px-4 py-2">
      @livewire('sort', ['field' => 'email', 'label' => 'Email'])
    </th>

    <th class="px-4 py-2">
      @livewire('sort', ['field' => 'created_at', 'label' => 'Date Created'])
    </th>

    <th class="px-4 py-2">
      @livewire('sort', ['field' => 'updated_at', 'label' => 'Date Modified'])
    </th>
  </tr>
</thead>
...
```

## Configuration

You may publish the package's configuration so as to make changes to it.

To publish,

```shell
php artisan vendor:publish --provider="Systemattic\LivewireSort\LivewireSortServiceProvider" --tag="config"
```

This would be published to the default config folder as `livewire_sort.php`.
