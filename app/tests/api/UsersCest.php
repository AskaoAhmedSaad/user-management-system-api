<?php
namespace tests\api;

use ApiTester;
use \Codeception\Util\HttpCode;
use Faker\Factory;
use app\tests\fixtures\Users\UsersFixture;

class UsersCest
{
    public function _before(ApiTester $I) {
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
            'users' => [
                'class' => UsersFixture::className(),
                'dataFile' => 'tests/fixtures/Users/data/users.php'
            ],
        ];
    }

    public function testPositiveAddingNewUser(ApiTester $I)
    {
        $faker = Factory::create();
        $params = [
                "name" => $faker->name,
            ];
        $I->wantTo('test positive adding new user');
        $I->sendPOST('users', $params);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["success"=>true, "data" => $params]);
    }

    public function testNegativeAddingNewUserWithoutSendingName(ApiTester $I)
    {
        $faker = Factory::create();
        $params = [];
        $I->wantTo('test negative adding new user without sending name');
        $I->sendPOST('users', $params);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["error" => true,"data" =>  [ "name" =>  [ "The name field is required."]]]);
    }

    public function testNegativeAddingNewUserWithDuplicatedName(ApiTester $I)
    {
        $faker = Factory::create();
        $params = [
                "name" => $faker->name,
            ];
        $I->wantTo('test negative adding new user with duplicated name');
        $I->sendPOST('users', $params);
        $I->sendPOST('users', $params);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["error" => true]);
        $I->seeResponseContains("has already been taken");
    }

    public function testPositiveDeleteUser(ApiTester $I)
    {
        $I->wantTo('test positive deleting user');
        $I->sendDelete('users/1');
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["deleted" => true]);
    }

    public function testNegativeDeleteUserAlreadyDeleted(ApiTester $I)
    {
        $I->wantTo('test positive deleting user');
        $I->sendDelete('users/1');
        $I->sendDelete('users/1');
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
    }
}