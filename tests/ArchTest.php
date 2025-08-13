<?php

use PHPUnit\Framework\TestCase;

arch()->preset()->php();
arch()->preset()->security()->ignoring('md5');

// Controllers tests - only check application controllers, not auth controllers
arch('application controllers have standard methods')
    ->expect('App\Http\Controllers\EngineExpertController')
    ->toHaveMethod('index')
    ->and('App\Http\Controllers\EngineExpertController')
    ->toHaveMethod('store');

// Models tests
arch('models have proper documentation')
    ->expect('App\Models')
    ->toHavePropertiesDocumented();

// Security tests
arch('avoid using risky functions')
    ->expect(['eval', 'shell_exec', 'system', 'passthru', 'exec'])
    ->not->toBeUsed();

// Test directory structure  
arch('feature tests extend TestCase')
    ->expect('Tests\Feature')
    ->toExtend(TestCase::class);

arch('unit tests extend TestCase')
    ->expect('Tests\Unit')
    ->toExtend(TestCase::class);