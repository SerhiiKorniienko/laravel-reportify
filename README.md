# Simple Laravel package for content reporting and moderation

[![Latest Version on Packagist](https://img.shields.io/packagist/v/serhiikorniienko/laravel-reportify.svg?style=flat-square)](https://packagist.org/packages/serhiikorniienko/laravel-reportify)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/serhiikorniienko/laravel-reportify/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/serhiikorniienko/laravel-reportify/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/serhiikorniienko/laravel-reportify/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/serhiikorniienko/laravel-reportify/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/serhiikorniienko/laravel-reportify.svg?style=flat-square)](https://packagist.org/packages/serhiikorniienko/laravel-reportify)

Simple, yet powerful package for content reporting and moderation in Laravel applications. Add a `Reportable` trait to your models and you're ready to go.

## Installation

You can install the package via composer:

```bash
composer require serhiikorniienko/laravel-reportify
```

You can simply run install command to publish config, migrations and migrate the database:
```bash
php artisan reportify:install
```

Alternatively, you can publish the migration and config file separately:

```bash
php artisan vendor:publish --tag="reportify-migrations"
php artisan migrate
```

And a config file:

```bash
php artisan vendor:publish --tag="reportify-config"
```

## Configuration

Basic configuration is stored in `config/reportify.php` file. You can change the default values there.

`global_threshold` - the number of reports required to mark a content as inappropriate for everyone.
```php
return [
    'global_threshold' => 3,
];
```

## Usage

Add the `Reportable` trait to get started
```php
use SerhiiKorniienko\Reportify\Reportable;

class MyModel extends Model
{
    // this trait adds the ability to report the model
    use Reportable;
}
```

Report your model using the `report` method
```php
    $model->report()
        ->withReporter($user)
        ->withReason('This is inappropriate content')
        ->withStatus('pending')
        ->create();
```

Check if the model should be available to a user
```php
    $model->visibleFor($user);
```
Currently, reportable model would not be visible for a user who has reported it. Also, it would not be visible for all users if the number of reports exceeds the global threshold.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [SerhiiKorniienko](https://github.com/SerhiiKorniienko)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
