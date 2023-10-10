<?php

declare(strict_types = 1);

namespace DigitalCreative\ExpandableTableRow\Http\Controllers;

use DigitalCreative\ExpandableTableRow\Http\Requests\BatchUpdateRequest;
use DigitalCreative\ExpandableTableRow\SingleFieldResource;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Exceptions\ResourceSaveCancelledException;
use Nova;

class UpdateController
{
    public function __invoke(BatchUpdateRequest $request, string $resourceName): ActionResponse
    {
        $resource = Nova::resourceInstanceForKey($resourceName);
        $attribute = $request->input('__attribute_name__');
        $field = $resource->availableFields($request)->firstWhere('attribute', $attribute);

        $request->toSelectedResourceQuery()->each(function (Model $model) use ($resource, $field, $request): void {

            $resource = $request->newResourceWith($model);
            $resource->authorizeToUpdate($request);

            $mockResource = new SingleFieldResource($resource, $field);
            $mockResource::validateForUpdate($request, $mockResource);

            [ $model, $callbacks ] = $mockResource::fillForUpdate($request, $model);

            if ($model->save() === false) {
                throw new ResourceSaveCancelledException();
            }

            foreach ($callbacks as $callback) {
                $callback->__invoke();
            }

            $resource::afterUpdate($request, $model);

        });

        return Action::message(__('The resource was updated!'));
    }
}
