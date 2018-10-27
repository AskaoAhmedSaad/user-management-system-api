<?php

use \Codeception\Util\Fixtures;
use \Codeception\Util\HttpCode;
use Faker\Factory;

class GroupsCest
{
    public function _before(ApiTester $I)
    {

    }

    public function _after(ApiTester $I)
    {
    }

    public function testPositiveAddingNewGroup(ApiTester $I)
    {
        $faker = Factory::create();
        $params = [
                "name" => $faker->name,
            ];
        $I->wantTo('test positive adding new group');
        $I->sendPOST('groups', $params);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["success"=>true, "data" => $params]);
    }

    public function testNegativeAddingNewGroupWithoutSendingName(ApiTester $I)
    {
        $faker = Factory::create();
        $params = [];
        $I->wantTo('test negative adding new group without sending name');
        $I->sendPOST('groups', $params);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["error" => true,"data" =>  [ "name" =>  [ "The name field is required."]]]);
    }
}
