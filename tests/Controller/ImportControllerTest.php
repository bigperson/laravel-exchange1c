<?php
/**
 * This file is part of bigperson/laravel-exchange1c package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests\Controller;

use Tests\TestCase;

class ImportControllerTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('exchange1c', require_once __DIR__.'./../../publish/config/exchange1c.php');
    }

    public function testRequest(): void
    {
        $response = $this->call(
            'GET',
            config('exchange1c.exchange_path').'?type=catalog&mode=checkauth',
            [],
            [],
            [],
            [
                'PHP_AUTH_USER' => config('exchange1c.login'),
                'PHP_AUTH_PW'   => config('exchange1c.password'),
            ]
        );
        $response->assertStatus(200);
    }

    public function testLogicException(): void
    {
        $response = $this->call(
            'GET',
            config('exchange1c.exchange_path').'?type=notsale&mode=checkauth',
            [],
            [],
            [],
            [
                'PHP_AUTH_USER' => config('exchange1c.login'),
                'PHP_AUTH_PW'   => config('exchange1c.password'),
            ]
        );
        $response->assertStatus(500);
    }

    public function testLoginExchange1CException(): void
    {
        $response = $this->call(
            'GET',
            config('exchange1c.exchange_path').'?type=notsale&mode=checkauth',
            [],
            [],
            [],
            [
                'PHP_AUTH_USER' => config('exchange1c.login'),
                'PHP_AUTH_PW'   => 'test',
            ]
        );
        $response->assertStatus(500);
    }

    public function testExchange1CException(): void
    {
        $response = $this->call(
            'GET',
            config('exchange1c.exchange_path').'?type=catalog&mode=testmode',
            [],
            [],
            [],
            [
                'PHP_AUTH_USER' => config('exchange1c.login'),
                'PHP_AUTH_PW'   => config('exchange1c.password'),
            ]
        );
        $response->assertStatus(500);
    }
}
