# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/epmnzava/tigosecure.svg?style=flat-square)](https://packagist.org/packages/epmnzava/tigosecure)
[![Build Status](https://img.shields.io/travis/epmnzava/tigosecure/master.svg?style=flat-square)](https://travis-ci.org/epmnzava/tigosecure)
[![Quality Score](https://img.shields.io/scrutinizer/g/epmnzava/tigosecure.svg?style=flat-square)](https://scrutinizer-ci.com/g/epmnzava/tigosecure)
[![Total Downloads](https://img.shields.io/packagist/dt/epmnzava/tigosecure.svg?style=flat-square)](https://packagist.org/packages/epmnzava/tigosecure)

This package is created to help developers intergrate with Tigopesa Tanzania secure online api 

## Installation

- Laravel Version: 5.8.36
- PHP Version: 8.0

You can install the package via composer:

```bash
composer require epmnzava/tigosecure
```

# Update your config (for Laravel 5.4 and below)
Add the service provider to the providers array in config/app.php:
```
Epmnzava\Tigosecure\TigosecureServiceProvider::class
```
Add the facade to the aliases array in config/app.php:
```
'Tigosecure'=>\Epmnzava\Tigosecure\TigosecureFacade::class,
```

# Publish the package configuration (for Laravel 5.4 and below)
Publish the configuration file and migrations by running the provided console command:
```
php artisan vendor:publish --provider="Epmnzava\Tigosecure\TigosecureServiceProvider"
```
### Environmental Variables
TIGO_CLIENT_ID ` your provided tigopesa client id `<br/>

TIGO_CLIENT_SECRET ` your provided tigopesa client secret `<br/>

TIGO_API_URL ` your provided tigopesa api url  `<br/>

TIGO_PIN ` your provided tigopesa pin number `<br/>

TIGO_ACCOUNT_NUMBER ` your provided tigopesa  account number `<br/>

TIGO_ACCOUNT_ID ` your provided tigopesa account id  `<br/>

TIGO_REDIRECT    ` your  redirect url `<br/>

TIGO_CALLBACK    ` your  callback url `<br/>

APP_CURRENCY_CODE ` currency put TZS for Tanzanian Shillings `<br/>

LANG ` language code en for english and sw for swalihi`<br/>

## Usage

This release does not come with database tables for transaction or payments you need to create then  After you have filled all necessary variables , providers and facases this is how the package can be used.

On your controller 

``` php
<?php

namespace App\Http\Controllers;

use Tigosecure;

use Illuminate\Http\Request;
class TransactionController extends Controller
{
//

    public function customer_transaction(){

        
        //Tigosecure::make_payment("customerfirstname","customerlastname","customerlastname","amount","transaction_id");
        $tigopesa_response=Tigosecure::make_payment("jacob","laizer","jacob@primeware.co.tz","3000","98778835628");

       
     return redirect($tigopesa_response->redirectUrl);

    }


```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email epmnzava@gmail.com instead of using the issue tracker.

## Credits

- [Emmanuel Mnzava](https://github.com/dbrax)
- [Victor Deo Kapten](https://github.com/vdkapten)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

