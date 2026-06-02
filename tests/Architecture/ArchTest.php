<?php

declare(strict_types=1);

arch('dd is never used')
    ->expect('dd')
    ->not->toBeUsed();

arch('dump is never used')
    ->expect('dump')
    ->not->toBeUsed();

arch('var_dump is never used')
    ->expect('var_dump')
    ->not->toBeUsed();

arch('admin controllers extend base Controller')
    ->expect('App\Http\Controllers\Admin')
    ->toExtend('App\Http\Controllers\Controller');

arch('admin controllers are classes')
    ->expect('App\Http\Controllers\Admin')
    ->toBeClasses();
