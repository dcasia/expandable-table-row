<?php

declare(strict_types = 1);

namespace DigitalCreative\ExpandableTableRow;

use Closure;
use Illuminate\Support\ServiceProvider;
use JsonSerializable;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Nova;

class ExpandableTableRowServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Field::macro('expandableRowData', function (Field|Closure $value): static {

            return $this->withMeta([
                'expandableRowData' => new class($this, $value) implements JsonSerializable {
                    public function __construct(
                        private readonly Field $parent,
                        private readonly Field|Closure $stackField,
                    )
                    {
                    }

                    public function jsonSerialize(): mixed
                    {
                        $stackField = value($this->stackField);
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
