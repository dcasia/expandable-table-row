<?php

declare(strict_types = 1);

namespace DigitalCreative\ExpandableTableRow\Http\Requests;

use Laravel\Nova\Http\Requests\ActionRequest;

class BatchUpdateRequest extends ActionRequest
{
    public function isUpdateOrUpdateAttachedRequest(): bool
    {
        return true;
    }
}
