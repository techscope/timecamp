<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */

namespace Techscope\Timecamp\Model;
// https://github.com/timecamp/timecamp-api/blob/master/sections/away-time.md

class AwayTimeModel extends BaseModel
{
    protected $fields = [
        // TODO: can't figure out how to populate data in these fields, talk with Kamil to see what triggers data to show up here
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
        $request = $this->guzzle->request('GET', "away_time/{$this->url_tail}?$http_get_string");

        $response = $this->getResponseAsArray($request);

        return $response;
    }
}