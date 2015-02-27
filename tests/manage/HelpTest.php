<?php


class HelpTest extends TestCase
{

    public function testHelp()
    {

        $this->slack([
            'trigger' => 'help',
        ]);

        $this->assertResponseOk();
        $this->assertEquals('1', $this->response->getContent());

    }

    public function testTouch()
    {

        $res = $this->slack([
            'trigger' => 'touch',
        ]);

        $res = $res->getData();
        $params = $this->makeParams();
        $this->assertEquals($params['user_id'], $res->attachments[0]->fields[0]->value);
        $this->assertEquals($params['channel_id'], $res->attachments[0]->fields[3]->value);

    }

}