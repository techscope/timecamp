<?php
namespace Techscope\TimecampTest;

use Techscope\Timecamp\Model\ClientModel;

/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 4/18/2017
 * Time: 9:12 PM
 */
class ClientTest extends BaseTest
{
    protected $client;
    protected $test_id;

    protected function setUp(){
        parent::setUp();
        $this->client = new ClientModel();
        $this->test_id = $this->getUID();
    }

    public function testCanAddRecords()
    {
        $added_record_ids = [];

        // Values for the items we want to add
        $initial_organizationName = "Dummy Corp {$this->test_id}";
        $initial_firstName = "Notareal";
        $initial_lastName = "Person";
        $initial_address = "123/4 Nowhere Ave.";
        $initial_email = "doesnt@anywhere.go";
        $initial_currencyId = "9"; // Euro

        $response = $this->client->add($initial_organizationName, [
            "firstName" => $initial_firstName,
            "lastName" => $initial_lastName,
            "address" => $initial_address,
            "email" => $initial_email,
            "currencyId" => $initial_currencyId,
        ]);

        $fields_that_should_be_returned = $this->client->getFieldsReturnedFor("RetAdd");
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response);
        }

        $added_record_ids[] = $response['clientId'];

        $new_response = $this->client->get();
        $array_with_values_to_test = $this->getArrayByKeyValue("clientId", $response['clientId'], $new_response);

        $this->assertTrue(is_array($array_with_values_to_test), "Could not fetch the data for added Client");

        $this->assertTrue($array_with_values_to_test["organizationName"] == $initial_organizationName, "Client: organizationName should have been updated to $initial_organizationName but is {$array_with_values_to_test["organizationName"]}");
        $this->assertTrue($array_with_values_to_test["firstName"] == $initial_firstName, "Client: firstName should have been updated to $initial_firstName but is {$array_with_values_to_test["firstName"]}");
        $this->assertTrue($array_with_values_to_test["lastName"] == $initial_lastName, "Client: lastName should have been updated to $initial_lastName but is {$array_with_values_to_test["lastName"]}");
        $this->assertTrue($array_with_values_to_test["address"] == $initial_address, "Client: address should have been updated to $initial_address but is {$array_with_values_to_test["address"]}");
        $this->assertTrue($array_with_values_to_test["email"] == $initial_email, "Client: email should have been updated to $initial_email but is {$array_with_values_to_test["email"]}");
        $this->assertTrue($array_with_values_to_test["currencyId"] == $initial_currencyId, "Client: currencyId should have been updated to $initial_currencyId but is {$array_with_values_to_test["currencyId"]}");

        return $added_record_ids;
    }

    public function testCanGetRecords()
    {
        $response = $this->client->get();

        $this->assertTrue(is_array($response[0]));

        $fields_that_should_be_returned = $this->client->getFieldsReturnedFor("RetGet");
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

        // Values for the items we want to add
        $new_organizationName = "Updated Dummy Corp {$this->test_id}";
        $new_firstName = "Still";
        $new_lastName = "Notreal";
        $new_address = "453 Everywhere Ave.";
        $new_email = "goes@everywhere.com";
        $new_currencyId = "1"; // Euro

        // Change the updatable data
        $response = $this->client->update($task_id_to_use, [
            "organizationName" => $new_organizationName,
            "firstName" => $new_firstName,
            "lastName" => $new_lastName,
            "address" => $new_address,
            "email" => $new_email,
            "currencyId" => $new_currencyId,
        ]);

        // Make sure all the proper fields are returned
        $fields_that_should_be_returned = $this->client->getFieldsReturnedFor("RetUpdate");
        foreach($fields_that_should_be_returned as $needed_field)
        {
            $this->assertArrayHasKey($needed_field, $response);
        }

        // Now test to make sure the entries were updated to the values we specified
        // TODO: If it's ever possible to query by Task ID, use that
        $raw_entries = $this->client->get();

        $array_with_values_to_test = $this->getArrayByKeyValue("clientId", $task_id_to_use, $raw_entries);

        $this->assertTrue(is_array($array_with_values_to_test), "Could not fetch the data for updated Task");

        $this->assertTrue($array_with_values_to_test["organizationName"] == $new_organizationName, "Client: organizationName should have been updated to $new_organizationName but is {$array_with_values_to_test["organizationName"]}");
        $this->assertTrue($array_with_values_to_test["firstName"] == $new_firstName, "Client: firstName should have been updated to $new_firstName but is {$array_with_values_to_test["firstName"]}");
        $this->assertTrue($array_with_values_to_test["lastName"] == $new_lastName, "Client: lastName should have been updated to $new_lastName but is {$array_with_values_to_test["lastName"]}");
        $this->assertTrue($array_with_values_to_test["address"] == $new_address, "Client: address should have been updated to $new_address but is {$array_with_values_to_test["address"]}");
        $this->assertTrue($array_with_values_to_test["email"] == $new_email, "Client: email should have been updated to $new_email but is {$array_with_values_to_test["email"]}");
        $this->assertTrue($array_with_values_to_test["currencyId"] == $new_currencyId, "Client: currencyId should have been updated to $new_currencyId but is {$array_with_values_to_test["currencyId"]}");
    }

    /**
    * @depends testCanAddRecords
    */
    public function testCanDeleteRecords($added_ids)
    {
        // First make sure that the entry we're going to test the delete on exists
        $raw_entries = $this->client->get();
        $array_with_values_to_test = $this->getArrayByKeyValue("clientId", $added_ids[0], $raw_entries);
        $this->assertTrue(is_array($array_with_values_to_test), "Could not data for TimeEntry delete test");

        $this->client->delete($added_ids[0]);

        // Make sure the entry no longer exists
        $raw_entries = $this->client->get();
        $array_with_values_to_test = $this->getArrayByKeyValue("clientId", $added_ids[0], $raw_entries);
        $this->assertFalse(is_array($array_with_values_to_test), "TimeEntry record could not be deleted");
    }
}