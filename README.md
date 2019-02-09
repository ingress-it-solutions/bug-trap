<p align="center">
    <a href="https://www.bugtrap.io" target="_blank"><img width="130" src="https://www.ingressit.com/images/icon128x121.png"></a>
</p>

# BugTrap

Laravel 5 package for logging errors to bugtrap.io

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

## Installation 

You can install the package through Composer.
```bash
composer require bugtrap/bugtrap
```
*In case of Laravel 5.5, you still need to manually register this as the service provider has to be the first provider that needs to be registered.*

You must install this service provider. Make this the very *first* provider in list.
```php
// config/app.php
'providers' => [
    // Make this very first provider
    BugTrap\ServiceProvider::class,
    
    //...
    //...
];
```

Then publish the config and migration file of the package using artisan.
```bash
php artisan vendor:publish --provider="BugTrap\ServiceProvider"
```
And adjust config file (`config/bugtrap.php`) with your desired settings.

Add to your Exception Handler's (`/app/Exceptions/Handler.php` by default) `report` method these line and add the use line:
```php
use BugTrap\BugTrap;
...

public function report(Exception $e)
{
    if ($this->shouldReport($e)) {
        (new BugTrap)->handle($e);
    }

    return parent::report($e);
}
```

## Usage

All that is left to do is to define 2 ENV configuration variables.

```
BT_KEY=
BT_PROJECT_KEY=
```

`BT_KEY` is your profile key which authorises your account to the API.
`BT_PROJECT_KEY` is your project API key which you receive when creating a project.

Get these variables at [bugtrap.com](https://www.bugtrap.com)

## Optional

You can also return a specific view if an error has been generated. This eliminates the ugly 'Whoops something went wrong' page.

All you have to do is create a view (`500.blade.php`) that you return for your user, recommended in the `views/errors` directory.

Then in your `App\Exceptions\Handler.php` add the following code inside the `render` method:

```php
if (($errorView = (new BugTrap)->errorView()) !== false) {
    return $errorView;
}
```

Make sure you add this **before** the `return parent::render($request, $exception);` code.

Example:

```php
/**
 * Render an exception into an HTTP response.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \Exception  $exception
 * @return \Illuminate\Http\Response
 */
public function render($request, Exception $exception)
{
    ...

    if (($errorView = (new BugTrap)->errorView()) !== false) {
        return $errorView;
    }

    return parent::render($request, $exception);
}
```

## License

The bugtrap package is open source software licensed under the [license MIT](http://opensource.org/licenses/MIT)

## Contributors


