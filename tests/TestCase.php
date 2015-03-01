<?php

use FintechFab\Pepper\Slack\Models\User;

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
            'user_name'    => 'Pepper User',
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


    public function tearDown()
    {
        User::truncate();
        parent::tearDown();
        Mockery::close();
    }

}
