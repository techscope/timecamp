<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */

namespace Techscope\Timecamp;


use Faker\Provider\Base;

class ProjectModel extends BaseModel
{
    protected $fields = [
        "name",
        "tags",
        "budget",
        "id"
    ];

    public function get()
    {

    }
}