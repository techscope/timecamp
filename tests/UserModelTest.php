<?php
namespace Techscope\TimecampTest;

use Techscope\Timecamp\Model\UserModel;

/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 4/18/2017
 * Time: 9:12 PM
 */
class UserModelTest extends BaseTest
{
    protected $user;
    protected $test_id;

    protected function setUp(){
        parent::setUp();
        $this->user = new UserModel();
        $this->test_id = $this->getUID();
    }

    public function testCanGetRecords()
    {
        $response = $this->user->get();

        $this->assertTrue(is_array($response[0]));

        $fields_that_should_be_returned = $this->user->getFieldsReturnedFor("RetGet");
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response[0]);
        }
    }
}