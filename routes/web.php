<?php


Route::prefix('{locale}')->group(function () {
    Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {

    });

    Route::prefix('client')->middleware(['auth', 'role:client'])->group(function () {

    });
});
