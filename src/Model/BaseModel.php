<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */
namespace Techscope\Timecamp\Model;

use Carbon\Carbon;
use Dotenv\Dotenv;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Client;
use GuzzleHttp\Post\PostBodyInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Crypt;
use Psr\Http\Message\ResponseInterface;

abstract class BaseModel
{
    protected $api_key;
    protected $base_url;
    protected $guzzle;
    protected $debug;
    protected $url_tail;
    protected $fields;

    public function __construct()
    {
        // Load Dotenv depending on version
        $env_filepath = __DIR__ . '/../..'; // TODO: change for production
        if(class_exists('\\Dotenv')) // v1
        {
            \Dotenv::load(__DIR__ . '/../..');
        } else {
            $dotenv = new \Dotenv\Dotenv($env_filepath);
            $dotenv->load();
        }

        // Set the configuration values
        $this->api_key = getenv('TIMECAMP_API_TOKEN');
        $this->base_url = getenv('TIMECAMP_BASE_URL');
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

    public function getFieldsReturnedFor($fields_array_value)
    {
        $fields_returned_in_add_method = [];
        foreach($this->fields as $key => $value)
        {
            foreach($value as $return_type)
            {
                if($return_type == $fields_array_value)
                {
                    $fields_returned_in_add_method[] = $key;
                }
            }
        }

        return $fields_returned_in_add_method;
    }
}