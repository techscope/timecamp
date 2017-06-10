<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */

namespace Techscope\Timecamp;


use Faker\Provider\Base;

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

    public function get()
    {

    }

    public function update()
    {

    }

    public function create()
    {

    }

    // See https://github.com/timecamp/timecamp-api/blob/master/sections/time-entries.md GET /entries_changes
    public function getChanges()
    {
        
    }
}