<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */

namespace Techscope\Timecamp;


use Faker\Provider\Base;

class TaskModel extends BaseModel
{
    protected $fields = [
        "api_token",
        "api_token",
        "id",
        "user_id",
        "date",
        "task_id",
        "duration",
        "start_time",
        "end_time",
        "description",
        "billable",
        "invoiceId",
        "approval_id",
        "isValid",
        "isFilled"
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
        return $response;
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
        return $response;
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