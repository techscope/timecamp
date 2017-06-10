<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */

namespace Techscope\Timecamp;


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

    }
}