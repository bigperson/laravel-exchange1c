<?php

/**
 * This file is part of bigperson/laravel-exchange1c package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

return [
    'exchange_path' => '1c_exchange',
    'import_dir'    => storage_path('app/1c_exchange'),
    'login'         => 'admin',
    'password'      => 'admin',
    'use_zip'       => false,
    'file_part'     => 0,
    'models'        => [
        \Bigperson\Exchange1C\Interfaces\GroupInterface::class   => \App\Models\Category::class,
        \Bigperson\Exchange1C\Interfaces\ProductInterface::class => \App\Models\Product::class,
        \Bigperson\Exchange1C\Interfaces\OfferInterface::class   => \App\Models\Offer::class,
    ],
    'log_channel' => 'daily',
    'queue'       => 'default',
    'auth'        => [
        'custom'   => false,
        'callback' => function ($username, $password) {
            if ($username == 'admin' && $password == 'admin') {
                return true;
            }

            return false;
        },
    ],
];
