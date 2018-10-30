<?php
/**
 * This file is part of bigperson/laravel-exchange1c package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

$path = config('exchange1c.exchange_path', '1c_exchange');

Route::group(['middleware' => [\Illuminate\Session\Middleware\StartSession::class]], function () use ($path) {
    Route::match(['get', 'post'], $path, Bigperson\LaravelExchange1C\Controller\ImportController::class.'@request');
});
