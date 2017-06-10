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
}