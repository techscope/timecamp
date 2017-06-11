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

    protected function setUp(){
        parent::setUp();
        $this->time_entry = new TimeEntryModel();
        $this->test_id = $this->getUID();
    }

    public static function tearDownAfterClass()
    {
        // Delete Time Entries
        $time_entry = new TimeEntryModel();
        $test_entries = $time_entry->get('2000-05-31', '2000-06-02');
        foreach ($test_entries as $entry)
        {
            $time_entry->delete($entry['id']);
        }
    }

    public function testCanAddRecords()
    {
        $added_record_ids = [];

        $response = $this->time_entry->add('2000-06-01', 12, [
            "note" => "PHPUnit Test {$this->test_id}"
        ]);

        $fields_that_should_be_returned = $this->time_entry->getFieldsReturnedInAdd();
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response);
        }

        $added_record_ids[] = $response['entry_id'];

        return $added_record_ids;
    }

    public function testCanGetAllRecords()
    {
        $response = $this->time_entry->get();

        $this->assertTrue(is_array($response[0]));

        $fields_that_should_be_returned = $this->time_entry->getFieldsReturnedInGet();
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
        $entry_id_to_use = $added_ids[0];

        $new_duration = 14400;
        $new_note = 'Updated Test Entry';
        $new_start_time = '12:46:00';
        $new_end_time = '16:46:00';
        $new_billable = '1';
        $new_invoice_id = '123';
//        $new_task_id = 'T123'; TODO: Make sure a task runs before this one
        $new_update_activities = 1;

        // Change the updatable data
        $response = $this->time_entry->update($entry_id_to_use, [
            "duration" => $new_duration,
            "note" => $new_note,
            "start_time" => $new_start_time,
            "end_time" => $new_end_time,
            "billable" => $new_billable,
            "invoiceId" => $new_invoice_id,
            // TODO: Add the new task id later
            "updateActivities" => $new_update_activities
        ]);

        // Make sure all the proper fields are returned
        $fields_that_should_be_returned = $this->time_entry->getFieldsReturnedInUpdate();
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response);
        }

        // Now test to make sure the entries were updated to the values we specified
        // TODO: If it's ever possible to query by Entry ID, use that
        $raw_entries = $this->time_entry->get('2000-05-31', '2000-06-02');

        $array_with_values_to_test = $this->getArrayByKeyValue("id", $entry_id_to_use, $raw_entries);

        $this->assertTrue(is_array($array_with_values_to_test), "Could not fetch the data for updated TimeEntry");

        $this->assertTrue($array_with_values_to_test["duration"] == $new_duration, "TimeEntry: duration should have been updated to $new_duration but is {$array_with_values_to_test["duration"]}");
        $this->assertTrue($array_with_values_to_test["description"] == $new_note, "TimeEntry: description should have been updated to $new_note but is {$array_with_values_to_test["description"]}");
        $this->assertTrue($array_with_values_to_test["start_time"] == $new_start_time, "TimeEntry: start_time should have been updated to $new_start_time but is {$array_with_values_to_test["start_time"]}");
        $this->assertTrue($array_with_values_to_test["end_time"] == $new_end_time, "TimeEntry: end_time should have been updated to $new_end_time but is {$array_with_values_to_test["end_time"]}");
        $this->assertTrue($array_with_values_to_test["billable"] == $new_billable, "TimeEntry: billable should have been updated to $new_billable but is {$array_with_values_to_test["billable"]}");
        $this->assertTrue($array_with_values_to_test["invoiceId"] == $new_invoice_id, "TimeEntry: invoiceId should have been updated to $new_invoice_id but is {$array_with_values_to_test["invoiceId"]}");
    }

    /**
     * @depends testCanAddRecords
     */
    public function testCanDeleteRecords($added_ids)
    {
        // First make sure that the entry we're going to test the delete on exists
        $raw_entries = $this->time_entry->get('2000-05-31', '2000-06-02');
        $array_with_values_to_test = $this->getArrayByKeyValue("id", $added_ids[0], $raw_entries);
        $this->assertTrue(is_array($array_with_values_to_test), "Could not data for TimeEntry delete test");

        $this->time_entry->delete($added_ids[0]);

        // Make sure the entry no longer exists
        $raw_entries = $this->time_entry->get('2000-05-31', '2000-06-02');
        $array_with_values_to_test = $this->getArrayByKeyValue("id", $added_ids[0], $raw_entries);
        $this->assertFalse(is_array($array_with_values_to_test), "TimeEntry record could not be deleted");
    }
}