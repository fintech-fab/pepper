<?php namespace App\Http\Middleware;

use Closure;

class Slack
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

        $text = trim(\Input::get('text'));
        $trigger = trim(\Input::get('trigger_word'));

        if (!$text || !$trigger || strpos($text, $trigger . ' ') !== 0) {
            return \Response::make();
        }


        return $next($request);
    }

}
