<?php


namespace FintechFab\Pepper\Web\Controllers;


use App\Http\Controllers\Controller;
use FintechFab\Pepper\Slack\Components\UserComponent;
use FintechFab\Pepper\Slack\Models\User;
use View;

class WebController extends Controller
{

    public function users()
    {
        $users = User::all();

        return View::make('web::users', [
            'users' => $users,
        ]);
    }

    public function settings($id)
    {
        $user = User::find($id);

        return View::make('web::settings', [
            'user' => $user,
        ]);
    }

    public function postSettings($id)
    {

        $user = UserComponent::instance()->initById($id);

        $redmineKey = \Input::get('redmine-key');
        $redmineKey = trim($redmineKey);
        $user->setRedmineKey($redmineKey);

        return \Redirect::to('/web/user/' . $id . '/settings');

    }

}