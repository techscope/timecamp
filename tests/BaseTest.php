<?php
namespace Techscope\TimecampTest;
/**
 * Created by PhpStorm.
 * User: christian.soseman
 * Date: 4/18/2017
 * Time: 9:12 PM
 */

class BaseTest extends \PHPUnit_Framework_TestCase
{
    public function getUID()
    {
        $uid = substr(md5(microtime()), 0, 4);
        return $uid;
    }
}