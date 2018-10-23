# Laravel exchange 1c
![Packagist](https://img.shields.io/packagist/l/bigperson/laravel-exchange1c.svg?style=flat-square)
[![Packagist](https://img.shields.io/packagist/dt/bigperson/laravel-exchange1c.svg?style=flat-square)](https://packagist.org/packages/bigperson/laravel-exchange1c)
[![Packagist](https://img.shields.io/packagist/v/bigperson/laravel-exchange1c.svg?style=flat-square)](https://packagist.org/packages/bigperson/laravel-exchange1c)
[![Travis (.org)](https://img.shields.io/travis/bigperson/laravel-exchange1c.svg?style=flat-square)](https://travis-ci.org/bigperson/laravel-exchange1c)
[![Codecov](https://img.shields.io/codecov/c/github/bigperson/laravel-exchange1c.svg?style=flat-square)](https://codecov.io/gh/bigperson/laravel-exchange1c)
[![StyleCI](https://github.styleci.io/repos/154342667/shield?branch=master)](https://github.styleci.io/repos/154342667)

Пакет признан облегчить интеграцию 1с предприятия и сайта на laravel. Пакет является по сути мостом между laravel и пакетом https://github.com/bigperson/exchange1c.

## Установка
Установить зависимости
```
composer require bigperson/laravel-exchange1c
```

### Для Laravel 5.4 и ниже 
Добавить сервис провайдер Exchange1CServiceProvider в `config/app.php`
```php
Bigperson\LaravelExchange1C\Exchange1CServiceProvider::class
```
 
### Опубликовать конфиги
```
php artisan vendor:publish --provider="Bigperson\LaravelExchange1C\Exchange1CServiceProvider"
```
 
## Использование
Вам необходимо в конфиге указать, логин, пароль, свои модели и реализовать соответсвующие интерфейсы
```php
\Bigperson\Exchange1C\Interfaces\GroupInterface::class   => \App\Models\Category::class,
\Bigperson\Exchange1C\Interfaces\ProductInterface::class => \App\Models\Product::class,
\Bigperson\Exchange1C\Interfaces\OfferInterface::class   => \App\Models\Offer::class,
```
Подробнее о методах, которые необходимо реализовать можно прочитать в документации к модулю [carono/yii2-1c-exchange]((https://github.com/carono/yii2-1c-exchange#%D0%98%D0%BD%D1%82%D0%B5%D1%80%D1%84%D0%B5%D0%B9%D1%81%D1%8B))
Также необходимо [настроить 1С предприятие](https://github.com/carono/yii2-1c-exchange#%D0%9D%D0%B0%D1%81%D1%82%D1%80%D0%BE%D0%B9%D0%BA%D0%B0-1%D0%A1) 

### Подписка на события
Вы можете подписаться на любое событие вызываемое внутри пакета [bigperson/exchange1c](https://github.com/bigperson/exchange1c/tree/master/src/Events) 
```php
'Bigperson\Exchange1C\Events\BeforeOffersSync' => [
    'App\Listeners\BeforeOffersSyncListener',
],
```

# Лицензия
Данный пакет является открытым кодом под лицензией [MIT license](LICENSE).
