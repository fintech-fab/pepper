<?php namespace App\Http\Middleware;

use Closure;
use Config;
use Response;

class WebAuth
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = Config::get('web.admin.user');
        $password = Config::get('web.admin.password');

        if (
            empty($user) ||
            empty($password) ||
            $user !== @$_SERVER['PHP_AUTH_USER'] ||
            $password !== @$_SERVER['PHP_AUTH_PW']
        ) {
            header('WWW-Authenticate: Basic realm="Need Auth"');
            header('HTTP/1.0 401 Unauthorized');

            echo Response::make('Need Auth');
            die();
        }

        return $next($request);

    }

}
