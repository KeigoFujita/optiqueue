<?php

arch('dd is never used')
    ->expect('dd')
    ->not->toBeUsed();

arch('dump is never used')
    ->expect('dump')
    ->not->toBeUsed();

arch('var_dump is never used')
    ->expect('var_dump')
    ->not->toBeUsed();
