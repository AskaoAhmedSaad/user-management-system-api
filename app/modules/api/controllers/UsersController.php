<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use Exception;
use app\modules\api\repositories\users\CreateUserRepository;
use app\modules\api\repositories\users\DeleteUserRepository;

class UsersController extends Controller
{
    protected $createUserRepository;
    protected $deleteUserRepository;

    public function __construct($id, $module, CreateUserRepository $createUserRepository, DeleteUserRepository $deleteUserRepository, $config = [])
    {
        $this->createUserRepository = $createUserRepository;
        $this->deleteUserRepository = $deleteUserRepository;
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
}
