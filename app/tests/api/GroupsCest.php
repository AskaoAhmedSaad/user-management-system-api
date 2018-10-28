<?php
namespace tests\api;

use ApiTester;
use \Codeception\Util\HttpCode;
use Faker\Factory;
use app\tests\fixtures\Groups\GroupsFixture;

class GroupsCest
{
    public function _before(\ApiTester $I) {
        $this->loadFixtures($this->createFixtures($this->globalFixtures()));
    }

    /**
     * Redeclare visibility because Codeception includes
     * all public methods that not starts from '_'
     * and not excluded by module settings, in actor class.
     */
    use \yii\test\FixtureTrait {
        loadFixtures as protected;
        fixtures as protected;
        globalFixtures as protected;
        unloadFixtures as protected;
        getFixtures as protected;
        getFixture as protected;
    }

    protected function globalFixtures() {
        return [
            'groups' => [
                'class' => GroupsFixture::className(),
                'dataFile' => 'tests/fixtures/Groups/data/groups.php'
            ],
        ];
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
        $params = [];
        $I->wantTo('test negative adding new group without sending name');
        $I->sendPOST('groups', $params);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["error" => true,"data" =>  [ "name" =>  [ "The name field is required."]]]);
    }

    public function testNegativeAddingNewGroupWithDuplicatedName(ApiTester $I)
    {
        $faker = Factory::create();
        $params = [
                "name" => $faker->name,
            ];
        $I->wantTo('test negative adding new group with duplicated name');
        $I->sendPOST('groups', $params);
        $I->sendPOST('groups', $params);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["error" => true]);
        $I->seeResponseContains("has already been taken");
    }

    public function testPositiveDeleteUser(ApiTester $I)
    {
        $I->wantTo('test positive deleting user');
        $I->sendDelete('groups/1');
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
    }

    public function testNegativeDeleteUserAlreadyDeleted(ApiTester $I)
    {
        $I->wantTo('test positive deleting user');
        $I->sendDelete('groups/1');
        $I->sendDelete('groups/1');
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        $I->seeResponseContains("The group in not found!");
    }
}
