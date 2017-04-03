<?php

namespace Techscope\Timecamp;

use Carbon\Carbon;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Client;
use GuzzleHttp\Post\PostBodyInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Crypt;
use Psr\Http\Message\ResponseInterface;

class Timecamp
{
    protected $api_key;
    protected $base_url;
    protected $guzzle;
    protected $debug;
    protected $url_tail;

    public function __construct()
    {
        // Set the configuration values
        $this->api_key = config('timecamp.api_token');
        $this->base_url = config('timecamp.base_url');
        $this->guzzle = new Guzzle(['base_uri' => $this->base_url]);
        $this->debug = false; // TODO: Use config to set this value
        $this->url_tail = 'format/json/api_token/' . $this->api_key;
    }

    /**
     * @param ResponseInterface $response
     * @return mixed
     *
     * Takes the XML response of the Finicity API call and returns the response as an array.
     */
    public function getResponseAsArray(ResponseInterface $response)
    {
        $json_string = (string) $response->getBody();
        $array = json_decode($json_string,TRUE);
        return $array;
    }

    public function getUsers()
    {
        $request = $this->guzzle->request('GET', "users/{$this->url_tail}");

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function getTasks($exclude_archived = 0)
    {
        $request = $this->guzzle->request('GET', "tasks/{$this->url_tail}", [
            "query" => [
                "exclude_archived" => $exclude_archived
            ]
        ]);

        // TODO: Figure out how to test archived

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function getTask($task_id)
    {
        $request = $this->guzzle->request('GET', "tasks/{$this->url_tail}/task_id/$task_id");

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function addTask()
    {
        // TODO: Add functionality for addTask
    }

    public function updateTask()
    {
        // TODO: Add functionality for updateTask
    }

    public function getTimeEntries($start_date, $end_date, $task_ids = [], $users = [], $with_subtasks = false)
    {
        $base_url = "entries/{$this->url_tail}/from/$start_date/to/$end_date";

        if(count($task_ids) > 0)
        {
            if(is_string($task_ids))
            {
                $base_url .= "/task_ids/$task_ids";
            } elseif(is_array($task_ids)) {
                $csv_tasks = implode(",", $task_ids);
                $base_url .= "/task_ids/$csv_tasks";
            }
        }

        if($with_subtasks === true)
        {
            $base_url .= "/with_subtasks/1";
        }

        if(count($users) > 0)
        {
            if(is_string($users))
            {
                $base_url .= "/user_ids/$users";
            } elseif(is_array($users)) {
                $csv_users = implode(",", $users);
                $base_url .= "/user_ids/$csv_users";
            }
        }

        $request = $this->guzzle->request('GET', $base_url);

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function addTimeEntry()
    {
        // TODO: Add functionality for updateTask
    }

    public function updateTimeEntry()
    {
        // TODO: Add functionality for updateTask
    }

    public function getRunningTasks()
    {
        $request = $this->guzzle->request('GET', "timer_running/{$this->url_tail}");

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function getEntryChanges($start_date, $end_date, $task_ids = [], $users = [], $limit = 0)
    {
        $base_url = "entries_changes/{$this->url_tail}/from/$start_date/to/$end_date";

        if(count($task_ids) > 0)
        {
            if(is_string($task_ids))
            {
                $base_url .= "/task_ids/$task_ids";
            } elseif(is_array($task_ids)) {
                $csv_tasks = implode(",", $task_ids);
                $base_url .= "/task_ids/$csv_tasks";
            }
        }

        if(count($users) > 0)
        {
            if(is_string($users))
            {
                $base_url .= "/user_ids/$users";
            } elseif(is_array($users)) {
                $csv_users = implode(",", $users);
                $base_url .= "/user_ids/$csv_users";
            }
        }

        if($limit > 0)
        {
            $base_url .= "/limit/$limit";
        }

        $request = $this->guzzle->request('GET', $base_url);

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function startTimer()
    {
        // TODO: Add functionality for updateTask
    }

    public function getStatusOfTimer()
    {
        // TODO: Add functionality for updateTask
    }

    public function stopTimer()
    {
        // TODO: Add functionality for updateTask
    }

    public function getActivity($date, $user_id = null)
    {
        $base_url = "activity/{$this->url_tail}/date/$date";

        if(!is_null($user_id))
        {
            $base_url .= "/user_id/$user_id";
        }

        $request = $this->guzzle->request('GET', $base_url);

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function getApplications($application_ids)
    {
        $base_url = "application/{$this->url_tail}";

        if(is_array($application_ids))
        {
            if(count($application_ids) > 0)
            {
                $csv_ids = implode(",", $application_ids);
                $base_url .= "/application_ids/$csv_ids";
            } else {
                throw new \Exception("You must specify at least one application ID as a parameter.");
            }
        } else {
            throw new \Exception("The application_ids parameter must be an array.");
        }

        $request = $this->guzzle->request('GET', $base_url);

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function getWindowTitles($window_title_ids)
    {
        $base_url = "window_title/{$this->url_tail}";

        if(is_array($window_title_ids))
        {
            if(count($window_title_ids) > 0)
            {
                $csv_ids = implode(",", $window_title_ids);
                $base_url .= "/window_title_ids/$csv_ids";
            } else {
                throw new \Exception("You must specify at least one window title ID as a parameter.");
            }
        } else {
            throw new \Exception("The window_title_ids parameter must be an array.");
        }

        $request = $this->guzzle->request('GET', $base_url);

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function addActivity()
    {
        $request = $this->guzzle->request('GET', "timer_running/{$this->url_tail}");

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function getClients()
    {
        $request = $this->guzzle->request('GET', "client/{$this->url_tail}");

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function addClient()
    {
        // TODO: Add functionality for updateTask
    }

    public function updateClient()
    {
        // TODO: Add functionality for updateTask
    }

    public function getCurrencies()
    {
        $request = $this->guzzle->request('GET', "currency/{$this->url_tail}");

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function getInvoices()
    {
        $request = $this->guzzle->request('GET', "invoice/{$this->url_tail}");

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function addInvoice()
    {
        // TODO: Add functionality for updateTask
    }

    public function updateInvoice()
    {
        // TODO: Add functionality for updateTask
    }
    
    public function getAttendance($start_date, $end_date, $users = [])
    {
        $base_url = "attendance/{$this->url_tail}/from/$start_date/to/$end_date";

        if(count($users) > 0)
        {
            if(is_string($users))
            {
                $base_url .= "/users/$users";
            } elseif(is_array($users)) {
                $csv_users = implode(",", $users);
                $base_url .= "/users/$csv_users";
            }
        }

        $request = $this->guzzle->request('GET', $base_url);

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function getAwayTime($start_date, $end_date, $users = [])
    {
        $base_url = "away_time/{$this->url_tail}/from/$start_date/to/$end_date";

        if(count($users) > 0)
        {
            if(is_string($users))
            {
                $base_url .= "/users/$users";
            } elseif(is_array($users)) {
                $csv_users = implode(",", $users);
                $base_url .= "/users/$csv_users";
            }
        }

        $request = $this->guzzle->request('GET', $base_url);

        $response = $this->getResponseAsArray($request);
        return $response;
    }
}
