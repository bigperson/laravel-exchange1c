<?php
/**
 * This file is part of bigperson/laravel-exchange1c package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Tests;

use Bigperson\Exchange1C\Interfaces\EventDispatcherInterface;
use Bigperson\Exchange1C\Interfaces\EventInterface;
use Bigperson\LaravelExchange1C\LaravelEventDispatcher;

class LaravelEventDispatcherTest extends TestCase
{
    public function testDispatch(): void
    {
        $dispatcher = $this->makeDispatcher();
        $event = $this->createMock(EventInterface::class);
        $this->assertNull($dispatcher->dispatch($event));
    }

    /**
     * @return LaravelEventDispatcher
     */
    private function makeDispatcher(): LaravelEventDispatcher
    {
        return $this->app->make(EventDispatcherInterface::class);
    }
}
