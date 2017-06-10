<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */
namespace Techscope\Timecamp;

use Carbon\Carbon;
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

    public function __construct()
    {
        // Set the configuration values
        $this->api_key = config('timecamp.api_token');
        $this->base_url = config('timecamp.base_url');
        $this->guzzle = new Guzzle(['base_uri' => $this->base_url]);
        $this->debug = false; // TODO: Use config to set this value
        $this->url_tail = 'format/json/api_token/' . $this->api_key;
    }

    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('config');
        }

        if (is_array($key)) {
            return app('config')->set($key);
        }

        return app('config')->get($key, $default);
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
}