<?php

namespace Tests\Unit\TestBase;

use Tests\TestCase;

class EnvironmentCheckedTestCase extends TestCase
{
    /**
     * setupBeforeClass
     *
     * @return void
     */
    public static function setupBeforeClass(): void
    {
        if (env('APP_ENV') !== "testing") {
            echo "USING THE WRONG ENVIRONMENT! ABORTING TESTS";
            exit;
        }
        parent::setupBeforeClass();
    }
}
