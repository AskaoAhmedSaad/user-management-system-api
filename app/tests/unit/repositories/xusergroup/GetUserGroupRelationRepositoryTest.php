<?php

namespace tests\repositories\xusergroup;

use Yii;
use yii\codeception\TestCase;
use Codeception\Specify;
use app\tests\fixtures\Groups\GroupsFixture;
use app\tests\fixtures\Users\UsersFixture;
use app\tests\fixtures\XUserGroup\XUserGroupFixture;

class GetUserGroupRelationRepositoryTest extends TestCase
{
    use Specify;
    protected $getUserGroupRelationRepository;
    
    protected function setUp()
    {
        parent::setUp();
        $this->getUserGroupRelationRepository = Yii::$container->get('GetUserGroupRelationRepository');
    }

    public function fixtures() {
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


    public function testGettingExistedUserAndGroupRel()
    {
        $this->specify("test existed user and group relation");
        $userAndGroupRel = $this->getUserGroupRelationRepository->GetUserAndGroupRel(1, 1);
        $this->assertNotNull($userAndGroupRel);
    }

    public function testGettingNonExistedUserAndGroupRel()
    {
        $this->specify("test non existed user and group relation");
        $userAndGroupRel = $this->getUserGroupRelationRepository->GetUserAndGroupRel(1, 2);
        $this->assertNull($userAndGroupRel);
    }

    public function testGetGroupUsersCount()
    {
        $this->specify("test getting group users count");
        $count = $this->getUserGroupRelationRepository->getGroupUsersCount(1);
        $this->assertInternalType('int', $count);
        $this->assertEquals($count, 2);
    }
}