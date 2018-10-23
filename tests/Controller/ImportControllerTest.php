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
    public function testRequest():void
    {
        $path = config('exchange1c.exchange_path');
        $response = $this->call(
            'GET',
            $path.'?type=catalog&mode=checkauth',
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

    public function testLogicException():void
    {
        $path = config('exchange1c.exchange_path');
        $response = $this->call(
            'GET',
            $path.'?type=sale&mode=checkauth',
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

    public function testLoginExchange1CException():void
    {
        $path = config('exchange1c.exchange_path');
        $response = $this->call(
            'GET',
            $path.'?type=sale&mode=checkauth',
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

    public function testExchange1CException():void
    {
        $path = config('exchange1c.exchange_path');
        $response = $this->call(
            'GET',
            $path.'?type=catalog&mode=testmode',
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
