<?php
/**
 * This file is part of laravel-exchange1c package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Bigperson\LaravelExchange1C;

use Bigperson\Exchange1C\Interfaces\EventDispatcherInterface;
use Bigperson\Exchange1C\Interfaces\EventInterface;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class LaravelEventDispatcher.
 */
class LaravelEventDispatcher implements EventDispatcherInterface
{
    /**
     * @var Dispatcher
     */
    protected $eventDispatcher;

    /**
     * LaravelEventDispatcher constructor.
     *
     * @param Dispatcher $eventDispatcher
     */
    public function __construct(Dispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param EventInterface $event
     */
    public function dispatch(EventInterface $event): void
    {
        $this->eventDispatcher->dispatch($event);
    }
}
