<?php
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 6/9/2017
 * Time: 7:28 PM
 */

namespace Techscope\Timecamp;


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

    public function get()
    {

    }

    public function update()
    {

    }

    public function create()
    {

    }
}