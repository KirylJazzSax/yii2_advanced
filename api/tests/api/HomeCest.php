<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.10.2019
 * Time: 9:25
 */

namespace api\tests\api;


use api\tests\ApiTester;

class HomeCest
{
    public function mainPage(ApiTester $I)
    {
        $I->sendGET('');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}