<?php
namespace Techscope\TimecampTest;

use Carbon\Carbon;
use Techscope\Timecamp\Model\AttendanceModel;

/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 4/18/2017
 * Time: 9:12 PM
 */
class AttendanceModelTest extends BaseTest
{
    protected $attendance;
    protected $test_id;

    protected function setUp(){
        parent::setUp();
        $this->attendance = new AttendanceModel();
        $this->test_id = $this->getUID();
    }

    public function testCanGetRecords()
    {
        // get today's date for the attendance "to" field value
        $today = Carbon::today()->toDateString();
        $response = $this->attendance->get('2016-01-01', $today);

        $this->assertTrue(is_array($response[0]));

        $fields_that_should_be_returned = $this->attendance->getFieldsReturnedFor("RetGet");
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response[0]);
        }
    }
}