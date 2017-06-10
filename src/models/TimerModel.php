<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */

namespace Techscope\Timecamp;


use Faker\Provider\Base;
// Docs here: https://github.com/timecamp/timecamp-api/blob/master/sections/time-entries.md under GET/timer_running
class TimerModel extends BaseModel
{
    protected $fields = [
        "isTimerRunning",
        "elapsed",
        "entry_id",
        "timer_id",
        "start_time",
        "task_id",
        "name",
        "external_task_id",
    ];

    public function getActive()
    {

    }

    public function getRunning()
    {
        return $this->getActive();
    }

    // for the following functions:
    // https://github.com/timecamp/timecamp-api/blob/master/sections/timer.md
    public function start()
    {

    }

    public function stop()
    {

    }
}