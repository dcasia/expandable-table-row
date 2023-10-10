<?php

declare(strict_types = 1);

use DigitalCreative\ExpandableTableRow\Http\Controllers\UpdateController;
use Illuminate\Support\Facades\Route;

Route::post('/{resource}/update', UpdateController::class)->name('nova.column-toggler.fields');
