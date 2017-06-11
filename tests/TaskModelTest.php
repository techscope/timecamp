<?php
namespace Techscope\TimecampTest;

use Techscope\Timecamp\Model\TaskModel;

/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 4/18/2017
 * Time: 9:12 PM
 */
class TaskModelTest extends BaseTest
{
    protected $task;
    protected $test_id;

    protected function setUp(){
        parent::setUp();
        $this->task = new TaskModel();
        $this->test_id = $this->getUID();
    }

    public static function tearDownAfterClass()
    {
        // Delete Time Entries
//        $time_entry = new TimeEntryModel();
//        $test_entries = $time_entry->get('2000-05-31', '2000-06-02');
//        foreach ($test_entries as $entry)
//        {
//            $time_entry->delete($entry['id']);
//        }
    }

    public function testCanAddRecords()
    {
        $added_record_ids = [];

        // Values for the items we want to add
        $initial_name = "TestTask{$this->getUID()}";
        $initial_tags = "TestTag1, TestTag2";
//        $initial_parent_id = ""; // TODO: add initial_parent_id
        $initial_external_task_id = "ExtTask1";
        $initial_external_parent_id = "ExtParent1";
        $initial_budgeted = "12";
        $initial_note = "TestNote1";
        $initial_archived = "1";
        $initial_billable = "1";
        $initial_budget_unit = "hours";
//        $initial_user_ids = ""; // TODO: add initial_users_ids
        $initial_role = "3";

        $response = $this->task->add($initial_name, [
            "tags" => $initial_tags,
//            "parent_id" => $initial_parent_id,
            "external_task_id" => $initial_external_task_id,
            "external_parent_id" => $initial_external_parent_id,
            "budgeted" => $initial_budgeted,
            "note" => $initial_note,
            "archived" => $initial_archived,
            "billable" => $initial_billable,
            "budget_unit" => $initial_budget_unit,
//            "user_ids" => $initial_user_ids,
            "role" => $initial_role
        ]);

        $fields_that_should_be_returned = $this->task->getFieldsReturnedFor("RetAdd");
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response);
        }

        $added_record_ids[] = $response['task_id'];

        $new_response = $this->task->get();
        $array_with_values_to_test = $this->getArrayByKeyValue("task_id", $response['task_id'], $new_response);

        $this->assertTrue(is_array($array_with_values_to_test), "Could not fetch the data for added Task");

        $this->assertTrue($array_with_values_to_test["tags"] == $initial_tags, "Task: tags should have been updated to $initial_tags but is {$array_with_values_to_test["tags"]}");
        $this->assertTrue($array_with_values_to_test["external_task_id"] == $initial_external_task_id, "Task: external_task_id should have been updated to $initial_external_task_id but is {$array_with_values_to_test["external_task_id"]}");
        $this->assertTrue($array_with_values_to_test["external_parent_id"] == $initial_external_parent_id, "Task: external_parent_id should have been updated to $initial_external_parent_id but is {$array_with_values_to_test["external_parent_id"]}");
        $this->assertTrue($array_with_values_to_test["budgeted"] == $initial_budgeted, "Task: budgeted should have been updated to $initial_budgeted but is {$array_with_values_to_test["budgeted"]}");
        // TODO: note is not being set or returned
//        $this->assertTrue($array_with_values_to_test["note"] == $initial_note, "Task: note should have been updated to $initial_note but is {$array_with_values_to_test["note"]}");
        $this->assertTrue($array_with_values_to_test["archived"] == $initial_archived, "Task: archived should have been updated to $initial_archived but is {$array_with_values_to_test["archived"]}");
        $this->assertTrue($array_with_values_to_test["billable"] == $initial_billable, "Task: billable should have been updated to $initial_billable but is {$array_with_values_to_test["billable"]}");
        $this->assertTrue($array_with_values_to_test["budget_unit"] == $initial_budget_unit, "Task: budget_unit should have been updated to $initial_budget_unit but is {$array_with_values_to_test["budget_unit"]}");
        // TODO: role is not included in GET so we can't test for this yet
//        $this->assertTrue($array_with_values_to_test["role"] == $initial_role, "Task: role should have been updated to $initial_role but is {$array_with_values_to_test["role"]}");

        return $added_record_ids;
    }

    public function testCanGetRecords()
    {
        $response = $this->task->get();

        $this->assertTrue(is_array($response[0]));

        $fields_that_should_be_returned = $this->task->getFieldsReturnedFor("RetGet");
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response[0]);
        }
    }

    /**
     * @depends testCanAddRecords
     */

    public function testCanUpdateRecords($added_ids)
    {
        $task_id_to_use = $added_ids[0];

        $new_name = "TestTaskUpdate{$this->getUID()}";
        $new_tags = "TestUpdateTag1, TestUpdateTag2";
        //$new_parent_id = ""; // TODO: add new_parent_id
        $new_external_task_id = "ExtUpdateTask1";
        $new_external_parent_id = "ExtUpdateParent1";
        $new_budgeted = "26";
        $new_note = "TestNoteUpdate1";
        $new_archived = "0";
        $new_billable = "0";
        $new_budget_unit = "fee";
        //$new_user_ids = ""; // TODO: add new_users_ids
        $new_role = "1";

        // Change the updatable data
        $response = $this->task->update($task_id_to_use, [
            "name" => $new_name,
            "tags" => $new_tags,
//            "parent_id" => $new_parent_id,
            "external_task_id" => $new_external_task_id,
            "external_parent_id" => $new_external_parent_id,
            "budgeted" => $new_budgeted,
            "note" => $new_note,
            "archived" => $new_archived,
            "billable" => $new_billable,
            "budget_unit" => $new_budget_unit,
//            "user_ids" => $new_user_ids,
            "role" => $new_role
        ]);

        // Make sure all the proper fields are returned
        $fields_that_should_be_returned = $this->task->getFieldsReturnedFor("RetUpdate");
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response);
        }

        // Now test to make sure the entries were updated to the values we specified
        // TODO: If it's ever possible to query by Task ID, use that
        $raw_entries = $this->task->get();

        $array_with_values_to_test = $this->getArrayByKeyValue("task_id", $task_id_to_use, $raw_entries);

        $this->assertTrue(is_array($array_with_values_to_test), "Could not fetch the data for updated Task");

        $this->assertTrue($array_with_values_to_test["name"] == $new_name, "Task: name should have been updated to $new_name but is {$array_with_values_to_test["name"]}");
        $this->assertTrue($array_with_values_to_test["tags"] == $new_tags, "Task: tags should have been updated to $new_tags but is {$array_with_values_to_test["tags"]}");
        $this->assertTrue($array_with_values_to_test["external_task_id"] == $new_external_task_id, "Task: external_task_id should have been updated to $new_external_task_id but is {$array_with_values_to_test["external_task_id"]}");
        $this->assertTrue($array_with_values_to_test["external_parent_id"] == $new_external_parent_id, "Task: external_parent_id should have been updated to $new_external_parent_id but is {$array_with_values_to_test["external_parent_id"]}");
        $this->assertTrue($array_with_values_to_test["budgeted"] == $new_budgeted, "Task: budgeted should have been updated to $new_budgeted but is {$array_with_values_to_test["budgeted"]}");
        // TODO: note is not being set or returned
//        $this->assertTrue($array_with_values_to_test["note"] == $new_note, "Task: note should have been updated to $new_note but is {$array_with_values_to_test["note"]}");
        $this->assertTrue($array_with_values_to_test["archived"] == $new_archived, "Task: archived should have been updated to $new_archived but is {$array_with_values_to_test["archived"]}");
        $this->assertTrue($array_with_values_to_test["billable"] == $new_billable, "Task: billable should have been updated to $new_billable but is {$array_with_values_to_test["billable"]}");
        $this->assertTrue($array_with_values_to_test["budget_unit"] == $new_budget_unit, "Task: budget_unit should have been updated to $new_budget_unit but is {$array_with_values_to_test["budget_unit"]}");
        // TODO: role is not included in GET so we can't test for this yet
//        $this->assertTrue($array_with_values_to_test["role"] == $new_role, "Task: role should have been updated to $new_role but is {$array_with_values_to_test["role"]}");
    }

    /**
     * @depends testCanAddRecords
     */
    public function testCanDeleteRecords($added_ids)
    {
        // TODO: There is no DELETE method for Tasks API. Talk to Kamil about this.
    }
}