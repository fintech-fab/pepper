<?php


namespace App\Http\Controllers;


use FintechFab\Pepper\Slack\Request;
use Response;

class SlackController extends Controller
{

    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request->init();
    }

    public function index()
    {


        switch ($this->request->trigger()) {

            case 'help':
                /** @noinspection PhpIncludeInspection */
                return require(app_path('/../static/help.md'));
                break;


            case 'touch':

                return $this->response([
                    'text'        => 'Познай самого себя',
                    'attachments' => [
                        [
                            'fields' => $this->request->getPublicData(),
                        ]
                    ],
                ]);

                break;

        }

        return '';

    }

    private function response($data)
    {
        return Response::json($data);
    }

}