<?php

namespace Kiekbjul\SesFeedbackInbound\Tests;

use Kiekbjul\SesFeedbackInbound\SesFeedbackInboundServiceProvider;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    use MockeryPHPUnitIntegration;

    protected function getPackageProviders($app): array
    {
        return [
            SesFeedbackInboundServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
    }
}
