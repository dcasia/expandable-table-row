# Expandable Table Row

[![Latest Version on Packagist](https://img.shields.io/packagist/v/digital-creative/expandable-table-row)](https://packagist.org/packages/digital-creative/expandable-table-row)
[![Total Downloads](https://img.shields.io/packagist/dt/digital-creative/expandable-table-row)](https://packagist.org/packages/digital-creative/expandable-table-row)
[![License](https://img.shields.io/packagist/l/digital-creative/expandable-table-row)](https://github.com/dcasia/expandable-table-row/blob/main/LICENSE)

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="https://raw.githubusercontent.com/dcasia/expandable-table-row/main/screenshots/dark.png">
  <img alt="Expandable Table Row in Action" src="https://raw.githubusercontent.com/dcasia/expandable-table-row/main/screenshots/light.png">
</picture>

Provides an easy way to append extra data to each row of your resource tables.

# Installation

You can install the package via composer:

```
composer require digital-creative/expandable-table-row
```

## Basic Usage

To use the new functionality, all you need to do is add the `->expandableRowData()` method to your field definition 
and return any class that extends Nova Field or an array of fields.

```php
class UserResource extends Resource
{
    public function fields(NovaRequest $request): array
    {
        return [
            //...
            Text::make('First Name')->expandableRowData(function () {
                return [
                    Line::make(null)->displayUsing(fn () => 'Name')->asSubTitle(),
                    Text::make('Full Name', fn (User $user) => sprintf('%s %s',$user->first_name, $user->last_name))->copyable(),
                    Text::make('Email')->copyable(),
                ];
            }),
    
            Text::make('Last Name')->expandableRowData(function () {
                return [
                    Line::make(null)->displayUsing(fn () => 'Address')->asSubTitle(),
                    Text::make('Country'),
                    Text::make('Address', fn (User $user) => sprintf(
                        '%s, %s, %s - %s', $user->city, $user->state, $user->address, $user->zipcode
                    ))->copyable(),
                ];
            }),
            //...          
        ];
    }
}
```

## Settings

You can configure several options by using `->expandableRowOptions()`. Below, you'll find an explanation of each.

```php
public function fields(NovaRequest $request): array
{
    return [
        Text::make('...')->expandableRowOptions([
            'span' => 2, // This makes the metadata take X much more columns.
            'expanded_by_default' => true, // This makes the table row start expanded by default.
            'preallocate_column_width' => true, // This will avoid the table column shifting when expanding / collapsing.
        ]),
    ];
}
```

## ⭐️ Show Your Support

Please give a ⭐️ if this project helped you!

### Other Packages You Might Like

- [Nova Welcome Card](https://github.com/dcasia/nova-welcome-card) - A configurable version of the `Help card` that comes with Nova.
- [Icon Action Toolbar](https://github.com/dcasia/icon-action-toolbar) - Replaces the default boring action menu with an inline row of icon-based actions.
- [Expandable Table Row](https://github.com/dcasia/expandable-table-row) - Provides an easy way to append extra data to each row of your resource tables.
- [Collapsible Resource Manager](https://github.com/dcasia/collapsible-resource-manager) - Provides an easy way to order and group your resources on the sidebar.
- [Resource Navigation Tab](https://github.com/dcasia/resource-navigation-tab) - Organize your resource fields into tabs.
- [Resource Navigation Link](https://github.com/dcasia/resource-navigation-link) - Create links to internal or external resources.
- [Nova Mega Filter](https://github.com/dcasia/nova-mega-filter) - Display all your filters in a card instead of a tiny dropdown!
- [Nova Pill Filter](https://github.com/dcasia/nova-pill-filter) - A Laravel Nova filter that renders into clickable pills.
- [Nova Slider Filter](https://github.com/dcasia/nova-slider-filter) - A Laravel Nova filter for picking range between a min/max value.
- [Nova Range Input Filter](https://github.com/dcasia/nova-range-input-filter) - A Laravel Nova range input filter.
- [Nova FilePond](https://github.com/dcasia/nova-filepond) - A Nova field for uploading File, Image and Video using Filepond.
- [Custom Relationship Field](https://github.com/dcasia/custom-relationship-field) - Emulate HasMany relationship without having a real relationship set between resources.
- [Column Toggler](https://github.com/dcasia/column-toggler) - A Laravel Nova package that allows you to hide/show columns in the index view.
- [Batch Edit Toolbar](https://github.com/dcasia/batch-edit-toolbar) - Allows you to update a single column of a resource all at once directly from the index page.

## License

The MIT License (MIT). Please see [License File](https://raw.githubusercontent.com/dcasia/expandable-table-row/master/LICENSE) for more information.
