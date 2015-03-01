<?php namespace FintechFab\Pepper;

use FintechFab\Pepper\Redmine\RedmineApi;
use FintechFab\Pepper\Slack\Components\UserComponent;
use Illuminate\Support\ServiceProvider;
use Redmine\Client;

class PepperServiceProvider extends ServiceProvider
{

    public function boot()
    {
    }

    public function register()
    {

        // RedmineApi Api Client
        $this->app->bind('RedmineClient', function ($app) {
            $user = UserComponent::instance()->get();
            if (!$user) {
                throw new \Exception('must be user initiate before call redmine client');
            }
            if (!$user->redmine || !$user->redmine->key) {
                throw new \Exception('must be user redmine key initiate before call redmine client');
            }

            return new Client(\Config::get('redmine.url'), $user->redmine->key);
        });

        // RedmineApi client wrapper
        $this->app->singleton('RedmineApi', function ($app) {
            return new RedmineApi();
        });


    }

}
