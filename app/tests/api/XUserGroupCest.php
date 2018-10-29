<?php
namespace tests\api;

use ApiTester;
use \Codeception\Util\HttpCode;
use app\tests\fixtures\Groups\GroupsFixture;
use app\tests\fixtures\Users\UsersFixture;
use app\tests\fixtures\XUserGroup\XUserGroupFixture;

class XUserGroupCest
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

    public function testPositiveAssignToGroup(ApiTester $I)
    {
        $params = [
                "group_id" => 2,
                "user_id" => 2,
            ];
        $I->wantTo('test positive assigning to group');
        $I->sendPOST('xusergroup', $params);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["success"=>true, "data" => $params]);
    }

    public function testNegativeAssignToGroupAlreadyAssigned(ApiTester $I)
    {
        $params = [
                "group_id" => 1,
                "user_id" => 1,
            ];
        $I->wantTo('test negative assigning to group already assigned');
        $I->sendPOST('xusergroup', $params);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["error" => true]);
        $I->seeResponseContains("the user already in the group");
    }

    public function testNegativeAssignToNotFoundGroup(ApiTester $I)
    {
        $params = [
                "group_id" => 100,
                "user_id" => 1,
            ];
        $I->wantTo('test negative assigning to not found group');
        $I->sendPOST('xusergroup', $params);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["error" => true]);
        $I->seeResponseContains("Group ID is invalid");
    }

    public function testNegativeAssignToNotFoundUser(ApiTester $I)
    {
        $params = [
                "group_id" => 1,
                "user_id" => 100,
            ];
        $I->wantTo('test negative assigning to not found user');
        $I->sendPOST('xusergroup', $params);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["error" => true]);
        $I->seeResponseContains("User ID is invalid");
    } 

    public function testPositiveRemoveUserFromGroup(ApiTester $I)
    {
        $params = [
                "group_id" => 1,
                "user_id" => 1,
            ];
        $I->wantTo('test positive removing user from group');
        $I->sendDELETE('xusergroup/remove-from-group', $params);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["success"=>true, "data" => $params]);
    }

    public function testNegativeRemoveUserNotInTheGroup(ApiTester $I)
    {
        $params = [
                "group_id" => 2,
                "user_id" => 2,
            ];
        $I->wantTo('test negative remove user not in the group');
        $I->sendDELETE('xusergroup/remove-from-group', $params);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(["error" => true]);
        $I->seeResponseContains("this user is not in this group");
    }
}
