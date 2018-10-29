<?php
namespace tests\api;

use ApiTester;
use \Codeception\Util\HttpCode;
use Faker\Factory;
use app\tests\fixtures\Groups\GroupsFixture;
use app\tests\fixtures\Users\UsersFixture;
use app\tests\fixtures\XUserGroup\XUserGroupFixture;

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
            'users' => [
                'class' => UsersFixture::className(),
                'dataFile' => 'tests/fixtures/Users/data/users.php'
            ],
            'x_user_group' => [
                'class' => XUserGroupFixture::className(),
                'dataFile' => 'tests/fixtures/XUserGroup/data/x_user_group.php'
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

    public function testPositiveDeleteGroup(ApiTester $I)
    {
        $I->wantTo('test positive deleting group');
        $I->sendDelete('groups/2');
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["deleted" => true]);
    }

    public function testNegativeDeleteGroupAlreadyDeleted(ApiTester $I)
    {
        $I->wantTo('test negative delete group already deleted');
        $I->sendDelete('groups/2');
        $I->sendDelete('groups/2');
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        $I->seeResponseContains("The group in not found!");
    }

    public function testNegativeDeleteGroupWhichHaveUsers(ApiTester $I)
    {
        $I->wantTo('test negative delete group which have users');
        $I->sendDelete('groups/1');
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        $I->seeResponseContains("The group has user and can't be deleted!");
    }
}
