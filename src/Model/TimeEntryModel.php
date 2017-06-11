<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */

namespace Techscope\Timecamp\Model;


use Carbon\Carbon;
use Faker\Provider\Base;
// https://github.com/timecamp/timecamp-api/blob/master/sections/time-entries.md
class TimeEntryModel extends BaseModel
{
    protected $fields = [
        "id" => ["RetGet"],
        "duration" => ["RetGet", "RetChanges"],
        "user_id" => ["RetGet", "RetUpdate", "RetChanges"],
        "user_name" => ["RetGet"],
        "description" => ["RetGet", "RetChanges"],
        "last_modify" => ["RetGet", "RetUpdate"],
        "edited" => ["RetChanges"],
        "billable" => ["RetGet", "RetUpdate", "RetChanges"],
        "task_id" => ["RetGet", "RetUpdate", "RetChanges"],
//        "timespan" => ["RetUpdate"],
        "date" => ["RetGet", "RetUpdate", "RetChanges"],
        "start_time" => ["RetGet", "RetChanges"],
        "end_time" => ["RetGet", "RetChanges"],
        "locked" =>["RetGet", "RetUpdate", "RetChanges"],
        "name" => ["RetGet"],
        "addons_external_id" => ["RetGet"],
        "invoiceId" => ["RetGet", "RetUpdate", "RetChanges"],
        "entry_id" => ["RetAdd", "RetUpdate", "RetChanges"],
        "note" => ["RetUpdate"],
        "start_time_hour" => ["RetUpdate"],
        "end_time_hour" => ["RetUpdate"],
        "old_time_span" => ["RetChanges"],
        "new_time_span" => ["RetChanges"]
    ];

    public function get($from_datetime = null, $to_datetime = null, $query_params = null)
    {
        if(is_null($to_datetime))
        {
            $query_params['to'] = Carbon::today()->toDateString();
        } else {
            $query_params['to'] = $to_datetime;
        }

        if(is_null($from_datetime))
        {
            $query_params['from'] = Carbon::today()->subWeeks(2)->toDateString();
        } else {
            $query_params['from'] = $from_datetime;
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

    public function add($date, $duration, array $parameters = [])
    {
        $parameters['date'] = $date;
        $parameters['duration'] = $duration;

        $request = $this->guzzle->request('POST', "entries/{$this->url_tail}", [
            'form_params' => $parameters
        ]);

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function delete($entry_id)
    {
        $parameters['id'] = $entry_id;

        $request = $this->guzzle->request('DELETE', "entries/{$this->url_tail}", [
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