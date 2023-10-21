<?php

declare(strict_types = 1);

namespace DigitalCreative\ExpandableTableRow;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use JsonSerializable;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Nova;

class ExpandableTableRowServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Field::macro('expandableRowOptions', fn (array $options) => $this->withMeta([
            'expandableRowOptions' => $options,
        ]));

        Field::macro('expandableRowData', function (Field|Closure|array $value): static {

            return $this->withMeta([
                'expandableRowData' => new class($this, $value) implements JsonSerializable {
                    public function __construct(
                        private readonly Field $parent,
                        private readonly Field|Closure|array $fields,
                    )
                    {
                    }

                    public function jsonSerialize(): mixed
                    {
                        $fields = value($this->fields);

                        $stackField = match (true) {
                            $fields instanceof Stack => $fields,
                            default => Stack::make(Str::random(), Arr::wrap($fields)),
                        };

                        $stackField->resolveForDisplay($this->parent->resource);

                        return $stackField;
                    }
                },
            ]);

        });

        Nova::serving(function (ServingNova $event): void {

            Nova::script('expandable-table-row', __DIR__ . '/../dist/js/tool.js');
            Nova::style('expandable-table-row', __DIR__ . '/../dist/css/card.css');

        });
    }
}
