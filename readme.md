# Laravel Packager

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-readme]][link-readme]

# Informação muito importante!
`kallbuloso/laravel-packager` é um pacote do Laravel que foi criado para gerar e gerenciar pacotes `(Packages)` e reutilizálos em sua aplicação Laravel. O `laravel-packager` é um pacote suportado e testado no `Laravel ^6.*`.

O `laravel-packager` é na verdade uma versão ligeiramente modificada de [Jeroen-G/laravel-packager](https://github.com/Jeroen-G/laravel-packager). Eu criei a minha própria versão do `laravel-packager` porque queria ter controle total sobre como os comandos são gerenciados, e também tenho minhas próprias necessidades quanto ao que preciso que o pacote faça. 

Se você achar que `Jeroen-G/laravel-packager` atende às suas necessidades melhor do que `kallbuloso/laravel-packager`, por qualquer motivo, use essa. Minha versão do pacote é destinada principalmente para as minhas próprias necessidades e não pretende ser um substituto ou concorrente para o outro pacote.

# Segue daqui...
This package provides you with a simple tool to set up a new package and it will let you focus on the development of the package instead of the boilerplate.

## Installation

Via Composer

```bash
$ composer require kallbuloso/laravel-packager --dev
```

If you do not run Laravel 5.5 (or higher), then add the service provider in `config/app.php`:

```php
kallbuloso\Packager\PackagerServiceProvider::class,
```

If you do run the package on Laravel 5.5+, [package auto-discovery](https://medium.com/@taylorotwell/package-auto-discovery-in-laravel-5-5-ea9e3ab20518) takes care of the magic of adding the service provider.
Be aware that the auto-discovery also means that this package is loaded in your production environment. Therefore you may [disable auto-discovery](https://laravel.com/docs/5.5/packages#package-discovery) and instead put in your `AppServiceProvider` something like this:

```php
if ($this->app->environment('local')) {
    $this->app->register('kallbuloso\Packager\PackagerServiceProvider');
}
```

Optional you can publish the configuration to provide a different service provider stub. The default is [here](https://github.com/jeroen-g/packager-skeleton).

```bash
$ php artisan vendor:publish --provider="kallbuloso\Packager\PackagerServiceProvider"
```

## Available commands

### New
**Command:**
```bash
$ php artisan packager:new MyVendor MyPackage
```

**Result:**
The command will handle practically everything for you. It will create a packages directory, creates the vendor and package directory in it, pulls in a skeleton package, sets up composer.json and creates a service provider.

**Options:**
```bash
$ php artisan packager:new MyVendor MyPackage --i
$ php artisan packager:new --i
```
The package will be created interactively, allowing to configure everything in the package's `composer.json`, such as the license and package description.

**Remarks:**
The new package will be based on [this custom skeleton](https://github.com/jeroen-g/packager-skeleton).

### Get & Git
**Command:**
``` bash
$ php artisan packager:get https://github.com/author/repository
$ php artisan packager:git https://github.com/author/repository
```

**Result:**
This will register the package in the app's `composer.json` file.
If the `packager:git` command is used, the entire Git repository is cloned. If `packager:get` is used, the package will be downloaded, without a repository. This also works with Bitbucket repositories, but you have to provide the flag `--host=bitbucket` for the `packager:get` command.

**Options:**
```bash
$ php artisan packager:get https://github.com/author/repository --branch=develop
$ php artisan packager:get https://github.com/author/repository MyVendor MyPackage
$ php artisan packager:git https://github.com/author/repository MyVendor MyPackage
```
It is possible to specify a branch with the `--branch` option. If you specify a vendor and name directly after the url, those will be used instead of the pieces of the url.

### Tests
**Command:**
```bash
$ php artisan packager:tests
```

**Result:**
Packager will go through all maintaining packages (in `packages/`) and publish their tests to `tests/packages`.
Add the following to phpunit.xml (under the other testsuites) in order to run the tests from the packages:
```xml
<testsuite name="Packages">
    <directory suffix="Test.php">./tests/packages</directory>
</testsuite>
```

**Options:**
```bash
$ php artisan packager:tests MyVendor MyPackage
```

**Remarks:**
If a tests folder exists, the files will be copied to a dedicated folder in the Laravel App tests folder. This allows you to use all of Laravel's own testing functions without any hassle.

### List
**Command:**
```bash
$ php artisan packager:list
```

**Result:**
An overview of all packages in the `/packages` directory.

### Remove
**Command:**
```bash
$ php artisan packager:remove MyVendor MyPackage
```

**Result:**
The `MyVendor\MyPackage` package is deleted, including its references in `composer.json` and `config/app.php`.

### Publish
**Command:**
```bash
$ php artisan packager:publish MyVendor MyPackage https://github.com/myvendor/mypackage
```

**Result:**
The `MyVendor\MyPackage` package will be published to Github using the provided url.

### Check
**Command:**
```bash
$ php artisan packager:check MyVendor MyPackage
```

**Result:**
The `MyVendor\MyPackage` package will be checked for security vulnerabilities using SensioLabs security checker.

**Remarks**
You first need to run

```bash
$ composer require sensiolabs/security-checker
```


## Issues with cURL SSL certificate
It turns out that, especially on Windows, there might arise some problems with the downloading of the skeleton, due to a file regarding SSL certificates missing on the OS. This can be solved by opening up your .env file and putting this in it:
```
CURL_VERIFY=false
```
Of course this means it will be less secure, but then again you are not supposed to run this package anywhere near a production environment.

## Extensions
DelveFore started to work on a cool project to use various Artisan `make:` commands for the packages, [check it out](https://github.com/DelveFore/laravel-packager-hermes)!

## Changelog

Please see [changelog.md](changelog.md) for what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Credits

- [JeroenG](https://github.com/Jeroen-G)
- [kallbuloso][link-author]
- [All Contributors][link-contributors]

## License

The EU Public License. Please see [license.md](license.md) for more information.


[ico-version]: https://img.shields.io/packagist/v/kallbuloso/laravel-packager/v/stable?format=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/kallbuloso/laravel-packager.svg?style=flat-square
[ico-readme]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/kallbuloso/laravel-packager
[link-downloads]: https://packagist.org/packages/kallbuloso/laravel-packager
[link-author]: https://github.com/kallbuloso
[link-readme]: LICENSE.md
[link-contributors]: ../../contributors]
