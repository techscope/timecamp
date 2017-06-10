<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */

namespace Techscope\Timecamp;


use Carbon\Carbon;
use Faker\Provider\Base;
// https://github.com/timecamp/timecamp-api/blob/master/sections/time-entries.md
class TimeEntryModel extends BaseModel
{
    protected $fields = [
        "id",
        "duration",
        "user_id",
        "description",
        "last_modify",
        "billable",
        "task_id",
        "date",
        "start_time",
        "name",
        "addons_external_id",
        "billable",
        "invoiceId"
    ];

    public function get($query_params = null)
    {
        if(!isset($query_params['to']))
        {
            $query_params['to'] = Carbon::today()->toDateString();
        }

        if(!isset($query_params['from']))
        {
            $query_params['from'] = Carbon::today()->subWeeks(2)->toDateString();
        }

        $http_get_string = http_build_query($query_params);
        $request = $this->guzzle->request('GET', "entries/{$this->url_tail}?$http_get_string");

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function update($entry_id, array $parameters)
    {
        $parameters['id'] = $entry_id;
        $request = $this->guzzle->request('PUT', "entries/{$this->url_tail}", [
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


    // See https://github.com/timecamp/timecamp-api/blob/master/sections/time-entries.md GET /entries_changes
    public function getChanges($query_params = null)
    {
        if(!isset($query_params['to']))
        {
            $query_params['to'] = Carbon::today()->toDateString();
        }

        if(!isset($query_params['from']))
        {
            $query_params['from'] = Carbon::today()->subWeeks(2)->toDateString();
        }

        $http_get_string = http_build_query($query_params);
        $request = $this->guzzle->request('GET', "entries_changes/{$this->url_tail}?$http_get_string");

        $response = $this->getResponseAsArray($request);
        return $response;
    }
}