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

        $trigger = !empty($input['trigger']) ? $input['trigger'] : 'slackbot';
        $text = !empty($input['text'])
            ? $input['text']
            : (
            !empty($input['trigger']) ? $input['trigger'] . ' parameter' : $trigger . ' parameter'
            );

        $params = [
            'token'        => 'XXXXXXXXXXXXXXXXXX',
            'team_id'      => 'T0001',
            'channel_id'   => 'C2147483705',
            'channel_name' => 'test',
            'timestamp'    => microtime(true),
            'user_id'      => 'user',
            'user_name'    => 'Pepper User',
            'text'         => $text,
            'trigger_word' => $trigger,
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
