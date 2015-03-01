<?php


use FintechFab\Pepper\Redmine\RedmineApi;
use FintechFab\Pepper\Slack\Components\UserComponent;

class RedmineTest extends \TestCase
{

    public function testIssues()
    {

        $user = UserComponent::create([
            'slack_id' => 'test-issues-redmine',
            'name'     => 'redmine-issues-test',
        ]);
        $user->get()->redmine()->create([
            'key'     => '123',
            'user_id' => '321',
        ]);

        $this->mockRedmine();
        $res = $this->slack([
            'trigger' => 'redmine',
            'text'    => 'redmine issues',
            'user_id' => 'test-issues-redmine',
        ]);

        $this->assertResponseOk();
        $json = $res->getData();

        $this->assertEquals('#12345 Issue subject', $json->attachments[0]->title);

    }


    private function mockRedmine()
    {
        $mock = Mockery::mock(RedmineApi::class);
        $mock->shouldReceive('myLastIssues')->once()->andReturn([
            [
                'id'         => '12345',
                'subject'    => 'Issue subject',
                'updated_on' => date('2014-02-21T05:58:00Z'),
                'author'     => [
                    'name' => 'Author Name',
                ],
                'project'    => [
                    'name' => 'Project Name',
                ],
                'status'     => [
                    'name' => 'Status Name',
                ],
            ]
        ]);
        $this->app->instance('RedmineApi', $mock);
    }


}