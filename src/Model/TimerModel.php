<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */

namespace Techscope\Timecamp\Model;


use Carbon\Carbon;
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
        $request = $this->guzzle->request('GET', "timer_running/{$this->url_tail}");

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function getRunning()
    {
        return $this->getActive();
    }

    // for the following functions:
    // https://github.com/timecamp/timecamp-api/blob/master/sections/timer.md
    public function start($parameters = [])
    {
        $parameters['action'] = 'start';

        $request = $this->guzzle->request('POST', "timer/{$this->url_tail}", [
            'form_params' => $parameters
        ]);

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function status()
    {
        $parameters['action'] = 'status';

        $request = $this->guzzle->request('POST', "timer/{$this->url_tail}", [
            'form_params' => $parameters
        ]);

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function stop($timer_id, $stopped_at = null)
    {
        $parameters['action'] = 'stop';
        $parameters['timer_id'] = $timer_id;

        if(is_null($stopped_at))
        {
            $parameters['stopped_at'] = Carbon::now()->toDateTimeString();
        }

        $request = $this->guzzle->request('POST', "timer/{$this->url_tail}", [
            'form_params' => $parameters
        ]);

        $response = $this->getResponseAsArray($request);
        return $response;
    }
}