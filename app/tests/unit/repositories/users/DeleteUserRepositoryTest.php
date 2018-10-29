<?php

namespace tests\repositories\users;

use Yii;
use yii\codeception\TestCase;
use Codeception\Specify;
use app\tests\fixtures\Users\UsersFixture;

class DeleteUserRepositoryTest extends TestCase
{
    use Specify;
    protected $deleteUserRepository;
    
    protected function setUp()
    {
        parent::setUp();
        $this->deleteUserRepository = Yii::$container->get('DeleteUserRepository');
    }

    public function fixtures() {
        return [
            'users' => [
                'class' => UsersFixture::className(),
                'dataFile' => 'tests/fixtures/Users/data/users.php'
            ],
        ];
    }

    public function testDeleteUser()
    {
        $this->specify("test deleting user");
        $data = $this->deleteUserRepository->delete(1);
        $this->assertNotNull($data);
        $this->assertTrue($data['data']['deleted'] == 1);
    }
}