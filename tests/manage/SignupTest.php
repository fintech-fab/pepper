<?php


use FintechFab\Pepper\Redmine\RedmineApi;
use FintechFab\Pepper\Slack\Components\UserComponent;
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
            'text' => 'touch',
        ]);

        $user = UserComponent::instance()->initBySlackId($params['user_id'])->get();
        $this->assertEquals($params['user_name'], $user->name);

    }

    public function testSetRedmineKey()
    {
        UserComponent::create([
            'slack_id' => 'test-redmine',
            'name'     => 'redmine-test',
        ]);

        $this->mockRedmine(321);
        $this->slack([
            'text'    => 'redmine set.key redmine-key-value',
            'user_id' => 'test-redmine',
        ]);

        $user = UserComponent::instance()->initBySlackId('test-redmine')->get();
        $this->assertEquals('redmine-key-value', $user->redmine->key);
        $this->assertEquals('321', $user->redmine->user_id);

    }


    private function mockRedmine($myId)
    {
        $mock = Mockery::mock(RedmineApi::class);
        $mock->shouldReceive('myId')->once()->andReturn($myId);
        $this->app->instance('RedmineApi', $mock);
    }


}