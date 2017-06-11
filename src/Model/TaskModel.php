<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */

namespace Techscope\Timecamp\Model;


use Faker\Provider\Base;

class TaskModel extends BaseModel
{
    protected $fields = [
        "task_id" => ["RetGet", "RetAdd", "RetUpdate"],
        "parent_id" => ["RetGet", "RetAdd", "RetUpdate"],
        "assigned_by" => ["RetGet", "RetAdd", "RetUpdate"],
        "assigned_to" => ["RetAdd", "RetUpdate"],
        "name" => ["RetGet", "RetAdd", "RetUpdate"],
        "external_task_id" => ["RetGet", "RetAdd", "RetUpdate"],
        "external_parent_id" => ["RetGet", "RetAdd", "RetUpdate"],
        "level" => ["RetGet", "RetAdd", "RetUpdate"],
        "add_date" => ["RetAdd", "RetUpdate"],
        "archived" => ["RetGet", "RetAdd", "RetUpdate"],
        "color" => ["RetGet", "RetAdd", "RetUpdate"],
        "tags" => ["RetGet", "RetAdd", "RetUpdate"],
        "budgeted" => ["RetGet", "RetAdd", "RetUpdate"],
        "checked_date" => ["RetAdd", "RetUpdate"],
        "budget_unit" => ["RetGet", "RetAdd", "RetUpdate"],
        "due_date" => ["RetAdd", "RetUpdate"],
        "note" => ["RetAdd", "RetUpdate"],
        "context" => ["RetAdd", "RetUpdate"],
        "folder" => ["RetAdd", "RetUpdate"],
        "repeat" => ["RetAdd", "RetUpdate"],
        "root_group_id" => ["RetGet", "RetAdd", "RetUpdate"],
        "billable" => ["RetGet", "RetAdd", "RetUpdate"],
        "user_access_type" => ["RetGet"]
        // TODO: Figure out a good way to handle the returned user array in GET
        // TODO: By default, an associated array is returned for all methods
    ];

    // TODO: Talk to Kamil; the note field should really be shown here
    public function get($task_id = null)
    {
        if(!is_null($task_id))
        {
            $request = $this->guzzle->request('GET', "tasks/{$this->url_tail}?task_id=$task_id");
        } else {
            $request = $this->guzzle->request('GET', "tasks/{$this->url_tail}");
        }

        $response = $this->getResponseAsArray($request);
        // For some reason these results are returned as an associative array with the key being an integer. This means
        // we can just use $response[0] to get the first value. To make this more standardize we are going to use
        // array_values() to strip the non-sequention numeric keys the API returns.
        return array_values($response);
    }

    public function update($task_id, array $parameters)
    {
        $parameters['task_id'] = $task_id;
        $request = $this->guzzle->request('PUT', "tasks/{$this->url_tail}", [
            'form_params' => $parameters
        ]);

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function add($name, array $parameters = [])
    {
        $parameters['name'] = $name;

        $request = $this->guzzle->request('POST', "tasks/{$this->url_tail}", [
            'form_params' => $parameters
        ]);

        $response = $this->getResponseAsArray($request);
        return array_values($response)[0];
    }

    // TODO: DELETE function not working. Find out if it is offered in the API
//    public function delete($task_id)
//    {
//        $request = $this->guzzle->request('DELETE', "tasks/{$this->url_tail}", [
//            'form_params' => [
//                "id" => $task_id
//            ]
//        ]);
//
//        $response = $this->getResponseAsArray($request);
//        return $response;
//    }
}