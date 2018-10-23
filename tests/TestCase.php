<?php
/**
 * This file is part of laravel-exchange1c package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests;

use Bigperson\LaravelExchange1C\Exchange1CServiceProvider;

/**
 * Class TestCase.
 */
abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @var bool
     */
    public $mockConsoleOutput = false;

    /**
     * @var string
     */
    protected const PACKAGE_PROVIDER = Exchange1CServiceProvider::class;

    /**
     * Get package providers.  At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [self::PACKAGE_PROVIDER];
    }
}
