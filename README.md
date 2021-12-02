# Generate Autonumbers for your Laravel Model

[![Latest Version on Packagist](https://img.shields.io/packagist/v/frikishaan/autonumber-laravel.svg?style=flat-square)](https://packagist.org/packages/frikishaan/autonumber-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/frikishaan/autonumber-laravel.svg?style=flat-square)](https://packagist.org/packages/frikishaan/autonumber-laravel)
![GitHub Actions](https://github.com/frikishaan/autonumber-laravel/actions/workflows/main.yml/badge.svg)
[![StyleCI](https://github.styleci.io/repos/433112240/shield?branch=main)](https://github.styleci.io/repos/433112240?branch=main)
[![License](https://img.shields.io/github/license/frikishaan/autonumber-laravel?style=flat-square)](LICENSE.md)


This package can help you in creating autonumbers for your laravel model. You can create autonumbers using the artisan command, and it will generate the autonumber whenever you create a record using your model.

## Installation

You can install the package via composer:

```bash
composer require frikishaan/autonumber-laravel
```

## Usage

First you have to run migration. It will create a table in your database named `autonumbers`.

```bash
php artisan migrate
```

Then use the below command to create autonumber -

```bash
php artisan autonumber:create
```
Use the `HasAutonumber` trait in your model. It will generate the autonumber when you create a record using your model.

```php
<?php

namespace App\Models;

use Frikishaan\Autonumber\Traits\HasAutonumber;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasAutonumber;

    protected $fillable = [
        'customer', 'amount',
    ];
}

```

### Testing

```bash
composer test
```

<!-- ### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently. -->

<!-- ## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details. -->

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


---
This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
