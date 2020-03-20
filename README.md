# Permission handling for Laravel using Gates with Route Names

[![Packagist Version](https://img.shields.io/packagist/v/fireworkweb/laravel-gates?style=for-the-badge)](https://packagist.org/packages/fireworkweb/laravel-gates)
[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/fireworkweb/laravel-gates/run-tests?style=for-the-badge)](https://github.com/fireworkweb/laravel-gates/actions?query=workflow%3Arun-tests)
[![Codecov](https://img.shields.io/codecov/c/github/fireworkweb/laravel-gates?style=for-the-badge)](https://codecov.io/gh/fireworkweb/laravel-gates)
[![Scrutinizer code quality (GitHub/Bitbucket)](https://img.shields.io/scrutinizer/quality/g/fireworkweb/laravel-gates?style=for-the-badge)](https://scrutinizer-ci.com/g/fireworkweb/laravel-gates)
[![Packagist Downloads](https://img.shields.io/packagist/dt/fireworkweb/laravel-gates?style=for-the-badge)](https://packagist.org/packages/fireworkweb/laravel-gates)

This package allows you to manage permissions using Gates with Route Names.

## Installation

You can install the package via composer:

```bash
composer require fireworkweb/laravel-gates
```

### Package Middlewares

This package comes 2 middlewares:

* `Gate` - Checks current route gates, if no matching gate, breaks
* `GateOptional` - Checks current route gates, if no matching gate, logs

You can add them inside your `app/Http/Kernel.php` file.

```php
protected $routeMiddleware = [
    // ...
    'gate' => \Fireworkweb\Gates\Middlewares\Gate::class,
    'gate_optional' => \Fireworkweb\Gates\Middlewares\GateOptional::class,
];
```

## Usage

Here is an example:

```php
Route::middleware('gate')->group(function () {
    // ...
    Route::get('posts/{post}/edit')->name('posts.edit');
});
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

That will register a gate `posts.edit` and on route `posts/1/edit` it will check if you on `App\Policies\Post@edit` injecting route parameters.

### Commands

You have commands to help you find routes without gate:

```bash
# it will get the routes that has `gate` middleware
fwd artisan gates:routes-without-gate

# in case you are using a custom middleware name or want to check the optional one
fwd artisan gates:routes-without-gate gate_optional
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
