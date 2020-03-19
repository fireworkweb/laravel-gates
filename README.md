# Permission handling for Laravel using Gates with Route Names

[![Latest Version on Packagist](https://img.shields.io/packagist/v/fireworkweb/laravel-gates.svg?style=flat-square)](https://packagist.org/packages/fireworkweb/laravel-gates)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/fireworkweb/laravel-gates/run-tests?label=tests)](https://github.com/fireworkweb/laravel-gates/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Quality Score](https://img.shields.io/scrutinizer/g/fireworkweb/laravel-gates.svg?style=flat-square)](https://scrutinizer-ci.com/g/fireworkweb/laravel-gates)
[![Total Downloads](https://img.shields.io/packagist/dt/fireworkweb/laravel-gates.svg?style=flat-square)](https://packagist.org/packages/fireworkweb/laravel-gates)

This package allows you to manage permissions using Gates with Route Names.

## Installation

You can install the package via composer:

```bash
composer require fireworkweb/laravel-gates
```

## Usage

Here is an example:

```php

Route::get('posts/{post}/edit')->name('posts.edit')->middleware('gate');
```

```php
<?php

namespace App\Policies;

use App\Post;
use App\User;
use Fireworkweb\Gates\Traits\HasGates;

class PolicyWithResourceGates
{
    use HasGates;

    protected static function gateRouteName() : string
    {
        return 'posts';
    }

    protected static function gateAbilities() : array
    {
        return [
            'edit' => 'edit',
        ];
    }

    public function edit(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email contact@fireworkweb.com instead of using the issue tracker.

## Credits

- [Daniel Polito](https://github.com/dbpolito)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
