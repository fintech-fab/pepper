<?php namespace App\Http\Middleware;

use App;
use Closure;
use Cookie;
use Crypt;
use Exception;
use FintechFab\Pepper\Slack\Components\UserComponent;
use Illuminate\Support\Facades\Input;
use Request;

class WebAuthMe
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

        if (!$this->parseKey()) {
            App::abort(400, 'bad request');
        }

        return $next($request);

    }


    public static function parseKey()
    {
        $key = Input::get('key');

        if (!$key) {
            $key = Cookie::get('me-settings');
        }

        if (!$key) {
            $key = explode('/', Request::url());
            $key = end($key);
        }

        if (!$key) {
            return false;
        }

        try {
            $key = Crypt::decrypt($key);
        } catch (Exception $e) {
            return false;
        }

        $key = explode('|', $key);
        if (count($key) !== 3) {
            return false;
        }

        if (
            $key[0] < time() - 60 * 20 ||
            $key[1] !== 'me-settings'
        ) {
            return false;
        }

        $user = UserComponent::instance()->initById($key[2]);
        if (!$user->get()) {
            return false;
        }

        return $user->get()->id;

    }


    public static function createKey($id)
    {
        return Crypt::encrypt(time() . '|me-settings|' . $id);
    }

    public static function cookie($key, $path = null)
    {
        return Cookie::make('me-settings', $key, 20, $path);
    }

    public static function createUrl($key)
    {
        return url('/web/me/auth/' . $key);
    }

}
