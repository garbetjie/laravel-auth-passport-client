<?php

namespace Garbetjie\Laravel\Auth\PassportClient;

use Illuminate\Auth\AuthManager;
use Illuminate\Auth\RequestGuard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Guards\TokenGuard;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\ResourceServer;

class PassportServiceProvider extends ServiceProvider
{
    public function register()
    {
        parent::register();

        $this->registerGuard();
    }

    private function registerGuard()
    {
        Auth::resolved(
            function(AuthManager $authManager) {
                $authManager->extend(
                    'passport-client',
                    function (Application $app, $name, $config) {
                        return new RequestGuard(
                            function ($request) use ($config) {
                                return (new TokenGuard(
                                    $this->app->make(ResourceServer::class),
                                    Auth::createUserProvider($config['provider']),
                                    $this->app->make(TokenRepository::class),
                                    $this->app->make(ClientRepository::class),
                                    $this->app->make('encrypter')
                                ))->client($request);
                            },
                            $this->app['request']
                        );
                    }
                );
            }
        );
    }
}
