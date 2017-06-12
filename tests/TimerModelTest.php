<?php
namespace Techscope\TimecampTest;

use Techscope\Timecamp\Model\TimerModel;

/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 4/18/2017
 * Time: 9:12 PM
 */
class TimerModelTest extends BaseTest
{
    protected $timer;
    protected $test_id;

    protected function setUp(){
        parent::setUp();
        $this->timer = new TimerModel();
        $this->test_id = $this->getUID();
    }

    public function testCanStartTimer()
    {
        $added_record_ids = [];

        $response = $this->timer->start();

        $fields_that_should_be_returned = $this->timer->getFieldsReturnedFor("RetStart");
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response);
        }

        $added_record_ids[] = [
            "timer_id" => $response['new_timer_id'],
            "entry_id" => $response['entry_id'],
        ];

//        $new_response = $this->task->get();
//        $array_with_values_to_test = $this->getArrayByKeyValue("task_id", $response['task_id'], $new_response);
//
//        $this->assertTrue(is_array($array_with_values_to_test), "Could not fetch the data for added Task");
//
//        $this->assertTrue($array_with_values_to_test["tags"] == $initial_tags, "Task: tags should have been updated to $initial_tags but is {$array_with_values_to_test["tags"]}");
//        $this->assertTrue($array_with_values_to_test["external_task_id"] == $initial_external_task_id, "Task: external_task_id should have been updated to $initial_external_task_id but is {$array_with_values_to_test["external_task_id"]}");
//        $this->assertTrue($array_with_values_to_test["external_parent_id"] == $initial_external_parent_id, "Task: external_parent_id should have been updated to $initial_external_parent_id but is {$array_with_values_to_test["external_parent_id"]}");
//        $this->assertTrue($array_with_values_to_test["budgeted"] == $initial_budgeted, "Task: budgeted should have been updated to $initial_budgeted but is {$array_with_values_to_test["budgeted"]}");
//        // TODO: note is not being set or returned
////        $this->assertTrue($array_with_values_to_test["note"] == $initial_note, "Task: note should have been updated to $initial_note but is {$array_with_values_to_test["note"]}");
//        $this->assertTrue($array_with_values_to_test["archived"] == $initial_archived, "Task: archived should have been updated to $initial_archived but is {$array_with_values_to_test["archived"]}");
//        $this->assertTrue($array_with_values_to_test["billable"] == $initial_billable, "Task: billable should have been updated to $initial_billable but is {$array_with_values_to_test["billable"]}");
//        $this->assertTrue($array_with_values_to_test["budget_unit"] == $initial_budget_unit, "Task: budget_unit should have been updated to $initial_budget_unit but is {$array_with_values_to_test["budget_unit"]}");
//        // TODO: role is not included in GET so we can't test for this yet
////        $this->assertTrue($array_with_values_to_test["role"] == $initial_role, "Task: role should have been updated to $initial_role but is {$array_with_values_to_test["role"]}");
//
        return $added_record_ids;
    }

    public function testCanGetTimerStatus()
    {
        $response = $this->timer->status();

        $this->assertTrue(is_array($response), "Timer status was not returned as an array");

        $fields_that_should_be_returned = $this->timer->getFieldsReturnedFor("RetStatus");
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response);
        }
    }

    public function testCanGetActiveTimers()
    {
        $response = $this->timer->getActive();

        $this->assertTrue(is_array($response), "Active timers was not returned as an array");

        $fields_that_should_be_returned = $this->timer->getFieldsReturnedFor("RetGetActive");
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response[0]);
        }
    }

    /**
     * @depends testCanStartTimer
     */
    public function testCanStopTimer($added_record_ids)
    {
        $response = $this->timer->stop($added_record_ids[0]["timer_id"]);

        $fields_that_should_be_returned = $this->timer->getFieldsReturnedFor("RetStop");
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response);
        }
    }

    // TODO: Add a test to delete the entries that were created here

}