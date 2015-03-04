<?php namespace FintechFab\Pepper;

use App\Http\Controllers\SlackController;
use App\Http\Middleware\WebAuthMe;
use FintechFab\Pepper\Redmine\RedmineApi;
use FintechFab\Pepper\Slack\Components\UserComponent;
use FintechFab\Pepper\Web\Controllers\WebController;
use Illuminate\Support\ServiceProvider;
use Redirect;
use Redmine\Client;
use Route;
use View;

class PepperServiceProvider extends ServiceProvider
{

    public function boot()
    {
    }

    public function register()
    {

        $this->bindings();
        $this->routes();
        $this->views();

    }


    private function bindings()
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

    private function routes()
    {

        Route::post('/slack', [
            'middleware' => 'slack',
            'uses'       => SlackController::class . '@index',
        ]);

        Route::group([
            'prefix'     => 'web',
            'middleware' => 'web.auth',
        ], function () {

            Route::get('users', WebController::class . '@users');
            Route::get('user/{id}/settings', WebController::class . '@settings');
            Route::post('user/{id}/settings', WebController::class . '@postSettings');

        });

        Route::group([
            'prefix'     => 'web/me',
            'middleware' => 'web.auth.me',
        ], function () {

            Route::get('auth/{key}', function ($key) {
                $cookie = WebAuthMe::cookie($key, '/web/me/user');
                $id = WebAuthMe::parseKey($key);

                return Redirect::to('/web/me/user/' . $id . '/settings')->withCookie($cookie);
            });
            Route::get('user/{id}/settings', WebController::class . '@settings');
            Route::post('user/{id}/settings', WebController::class . '@postSettings');

        });

    }

    private function views()
    {

        View::addNamespace('web', app_path('/../src/Web/Views'));
        View::addExtension('php', 'php');

    }


}
