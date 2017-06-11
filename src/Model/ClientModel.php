<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */

namespace Techscope\Timecamp\Model;


use Faker\Provider\Base;

class ClientModel extends BaseModel
{
    protected $fields = [
        "firstName",
        "lastName",
        "organizationName",
        "address",
        "currencyId",
        "email",
        "rootGroupId",
        "addedBy",
        "added",
        "clientId"
    ];

    // TODO: Talk to Kamil. This really should be able to be queried by individual ID.
    public function get()
    {
        $request = $this->guzzle->request('GET', "client/{$this->url_tail}");

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function update($client_id, array $parameters)
    {
        $parameters['clientId'] = $client_id;
        $request = $this->guzzle->request('PUT', "client/{$this->url_tail}", [
            'form_params' => $parameters
        ]);

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function add($org_name, array $parameters = [])
    {
        $parameters['organizationName'] = $org_name;

        $request = $this->guzzle->request('PUT', "client/{$this->url_tail}", [
            'form_params' => $parameters
        ]);

        $response = $this->getResponseAsArray($request);
        return $response;
    }

    public function delete($client_id)
    {
        $parameters['clientId'] = $client_id;

        $request = $this->guzzle->request('DELETE', "client/{$this->url_tail}", [
            'form_params' => $parameters
        ]);

        $response = $this->getResponseAsArray($request);
        return $response;
    }
}