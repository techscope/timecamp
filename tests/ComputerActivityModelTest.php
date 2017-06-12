<?php
namespace Techscope\TimecampTest;

use Techscope\Timecamp\Model\ComputerActivityModel;

/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 4/18/2017
 * Time: 9:12 PM
 */
class ComputerActivityModelTest extends BaseTest
{
    protected $activity;
    protected $test_id;

    protected function setUp(){
        parent::setUp();
        $this->activity = new ComputerActivityModel();
        $this->test_id = $this->getUID();
    }

    public function testCanGetRecords()
    {
        $response = $this->activity->get('2017-06-11',1003062);

        $this->assertTrue(is_array($response[0]));

        $fields_that_should_be_returned = $this->activity->getFieldsReturnedFor("RetGet");
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response[0]);
        }

        $application_id = $response[0]['application_id'];
        return $application_id;
    }

    /**
     * @depends testCanGetRecords
     */
    public function testCanGetApplicationRecords($application_id)
    {
        $response = $this->activity->getApplication($application_id);

        $this->assertTrue(is_array($response[0]));

        $fields_that_should_be_returned = $this->activity->getFieldsReturnedFor("RetGetApp");
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response[0]);
        }
    }

    public function add()
    {
        $initial_user_id = "";
        $initial_application_name = "";
        $initial_website_domain = "";
        $initial_window_title = "";
        $initial_start_time = "";
        $initial_end_time = "";
    }
}