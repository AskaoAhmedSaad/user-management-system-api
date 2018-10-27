<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use Exception;
use app\modules\api\repositories\users\CreateUserRepository;
use app\modules\api\repositories\users\DeleteUserRepository;
use app\modules\api\repositories\users\AssignUserToGroupRepositoryInterface;

class UsersController extends Controller
{
    protected $createUserRepository;
    protected $deleteUserRepository;
    protected $assignUserToGroupRepository;

    public function __construct($id, $module, CreateUserRepository $createUserRepository, DeleteUserRepository $deleteUserRepository,
                                    AssignUserToGroupRepositoryInterface $assignUserToGroupRepository, $config = [])
    {
        $this->createUserRepository = $createUserRepository;
        $this->deleteUserRepository = $deleteUserRepository;
        $this->assignUserToGroupRepository = $assignUserToGroupRepository;
        parent::__construct($id, $module, $config);
    }

    /**
     * create a new user
     **/
    public function actionCreate()
    {
        return $this->createUserRepository->create(Yii::$app->request->post());
    }

    /**
     * delete a user
     **/
    public function actionDelete(int $id)
    {
        return $this->deleteUserRepository->delete($id);
    }

    /**
     * assign user to group and remove him from another group
     **/
    public function actionAssignToGroup(int $id)
    {;
        return $this->assignUserToGroupRepository->assign($id, Yii::$app->request->post());
    }
}
