<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */

namespace Techscope\Timecamp\Model;
// https://github.com/timecamp/timecamp-api/blob/master/sections/computer-activities.md
class ComputerActivityModel extends BaseModel
{
    protected $fields = [
        "user_id" => ["RetGet"],
        "application_id" => ["RetGet", "RetGetApp"],
        "end_time" => ["RetGet"],
        "time_span" => ["RetGet"],
        "window_title_id" => ["RetGet"],
        "end_date" => ["RetGet"],
        "task_id" => ["RetGet"],
        "entry_id" => ["RetGet"],
        "app_name" => ["RetGetApp"],
        "aditional_info" => ["RetGetApp"],
        "full_name" => ["RetGetApp"],
        "category_id" => ["RetGetApp"]
        // TODO: can't figure out how to populate date in these fields, talk with Kamil to see what triggers data to show up here
    ];

    public function get($date, $user_id)
    {
        $query_params['date'] = $date;

        if(!is_null($user_id))
        {
            $query_params['user'] = $user_id;
        }

        $http_get_string = http_build_query($query_params);
        $request = $this->guzzle->request('GET', "activity/{$this->url_tail}?$http_get_string");

        $response = $this->getResponseAsArray($request);

        return $response;
    }

    public function add($application_name, $start_datetime, $end_datetime, $window_title = null, $website_domain = null)
    {
        $parameters['application_name'] = $application_name;
        $parameters['start_time'] = $start_datetime;
        $parameters['end_time'] = $end_datetime;

        if(!is_null($window_title))
            $parameters['window_title'] = $window_title;

        if(!is_null($website_domain))
            $parameters['website_domain'] = $website_domain;

        $request = $this->guzzle->request('POST', "activity/{$this->url_tail}", [
            'form_params' => $parameters
        ]);

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function getApplication($application_ids)
    {
        $query_params['application_ids'] = $application_ids;

        $http_get_string = http_build_query($query_params);
        $request = $this->guzzle->request('GET', "application/{$this->url_tail}?$http_get_string");

        $response = $this->getResponseAsArray($request);

        return array_values($response);
    }

    public function getWindow($window_ids)
    {
        $query_params['window_ids'] = $window_ids;

        $http_get_string = http_build_query($query_params);
        $request = $this->guzzle->request('GET', "window_title/{$this->url_tail}?$http_get_string");

        $response = $this->getResponseAsArray($request);

        return array_values($response);
    }


}