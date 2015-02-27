<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }


    protected function makeParams($input = [])
    {
        $params = [
            'token'        => 'XXXXXXXXXXXXXXXXXX',
            'team_id'      => 'T0001',
            'channel_id'   => 'C2147483705',
            'channel_name' => 'test',
            'timestamp'    => microtime(true),
            'user_id'      => 'user',
            'user_name'    => 'Steve',
            'text'         => 'slackbot What is the air-speed velocity of an unladen swallow?',
            'trigger_word' => !empty($input['trigger']) ? $input['trigger'] : 'slackbot',
        ];

        $params = array_merge($params, $input);

        return $params;

    }

    /**
     * @param $input
     *
     * @return \Illuminate\Http\Response|Illuminate\Http\JsonResponse
     */
    protected function slack($input)
    {
        return $this->call('post', '/slack', $this->makeParams($input));
    }

}
