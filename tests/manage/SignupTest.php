<?php


use FintechFab\Pepper\Slack\Models\User;

class SignupTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        User::truncate();
    }

    public function testTouchEmpty()
    {

        $params = $this->makeParams();

        $this->slack([
            'trigger' => 'touch',
        ]);

        $user = User::where('slack_id', $params['user_id'])->first();
        $this->assertEquals($params['user_name'], $user->name);

    }


}