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
        "user_id",
        "email",
        "login_count",
        "display_name",
        "synch_time",
        "login_time",
        "group_id"
    ];

    public function get()
    {
        $request = $this->guzzle->request('GET', "users/{$this->url_tail}");

        $response = $this->getResponseAsArray($request);
        return $response;
    }
}