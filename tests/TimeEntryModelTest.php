<?php
namespace Techscope\TimecampTest;

use Techscope\Timecamp\Model\TimeEntryModel;

/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 4/18/2017
 * Time: 9:12 PM
 */
class TimeEntryModelTest extends BaseTest
{
    protected $time_entry;
    protected $test_id;

    public function setUp(){
        parent::setUp();
        $this->time_entry = new TimeEntryModel();
        $this->test_id = $this->getUID();
    }

    public function tearDown(){ }

    public function testCanAddRecords()
    {
        $response = $this->time_entry->add('2017-06-10', 3600, [
            "note" => "PHPUnit Test {$this->test_id}"
        ]);

        $fields_that_should_be_returned = $this->time_entry->getFieldsReturnedInAdd();
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response);
        }
    }

    public function testCanGetAllRecords()
    {
        $response = $this->time_entry->add('2017-06-10', 3600, [
            "note" => "PHPUnit Test {$this->test_id}"
        ]);

        $fields_that_should_be_returned = $this->time_entry->getFieldsReturnedInAdd();
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response);
        }
    }
}