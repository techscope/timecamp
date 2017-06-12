<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */

namespace Techscope\Timecamp\Model;

class AttendanceModel extends BaseModel
{
    protected $fields = [
        "user_id" => ["RetGet"],
        "user_name" => ["RetGet"],
        "start_time" => ["RetGet"],
        "end_time" => ["RetGet"],
        "total_time" => ["RetGet"],
        "date" => ["RetGet"]
        // TODO: can't figure out how to populate date in these fields, talk with Kamil to see what triggers data to show up here
    ];

    public function get($from_date, $to_date, $user_csvs = null)
    {
        $query_params['from'] = $from_date;
        $query_params['to'] = $to_date;
        if(!is_null($user_csvs))
        {
            $query_params['users'] = $user_csvs;
        }

        $http_get_string = http_build_query($query_params);
        $request = $this->guzzle->request('GET', "attendance/{$this->url_tail}?$http_get_string");

        $response = $this->getResponseAsArray($request);

        return $response;
    }
}