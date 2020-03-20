Laravel Auth Passport Client Guard
==================================

A really small and simple [auth guard](https://laravel.com/docs/6.x/authentication#introduction) for 
[Laravel Passport](https://laravel.com/docs/6.x/passport) that treats the OAuth client just like a user.

When an OAuth client has authenticated using the `client_credentials` grant type, this package will allow you to access
the authenticated client through the `request()->user()` method call.

# Configuration

Configuration of this is really simple. Simply use the `passport-client` auth guard in `config/auth.php`:

```php
<?php

// in config/auth.php

return [
    'guards' => [
        'client' => [
            'driver' => 'passport-client',
            'provider' => 'client',
        ]
    ],

    'providers' => [
        'client' => [
            'driver' => 'eloquent',
            'model' => Laravel\Passport\Client::class,
        ]
    ]
];
```


# Usage

When wanting to fetch the OAuth client that authenticated, simply call the `->user()` method on the request object with
the name of the configured guard:

```php
<?php

class MyController extends \App\Http\Controllers\Controller
{
    public function myAction(\Illuminate\Http\Request $request)
    {
        $client = request()->user('client');
        // or
        $client = $request->user('client');
    }
}
```


# Changelog

* **2020-03-20**
    * Initial release.
