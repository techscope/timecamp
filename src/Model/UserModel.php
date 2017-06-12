<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */

namespace Techscope\Timecamp\Model;


use Faker\Provider\Base;

class UserModel extends BaseModel
{
    protected $fields = [
        "user_id" => ["RetGet"],
        "email" => ["RetGet"],
        "login_count" => ["RetGet"],
        "display_name" => ["RetGet"],
        "synch_time" => ["RetGet"],
        "login_time" => ["RetGet"],
        "group_id" => ["RetGet"]
    ];

    public function get()
    {
        $request = $this->guzzle->request('GET', "users/{$this->url_tail}");

        $response = $this->getResponseAsArray($request);
        return $response;
    }
}