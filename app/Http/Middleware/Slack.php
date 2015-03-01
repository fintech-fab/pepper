<?php namespace App\Http\Middleware;

use Closure;
use Input;
use Log;

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
        if (!empty($text) && empty($trigger)) {
            $trigger = explode(' ', $text)[0];
        }

        if (empty($text) || empty($trigger) || strpos($text, $trigger) !== 0) {
            $this->traceRequest('bad trigger');
            return \Response::make();
        }

        $token = \Input::get('token');
        if (empty($token) || $token !== \Config::get('slack.token')) {
            $this->traceRequest('bad token');
            return \Response::make();
        }

        return $next($request);
    }


    private function traceRequest($message)
    {
        if (\Config::get('slack.trace')) {
            Log::debug($message, Input::all());
        }
    }

}
