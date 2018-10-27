<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use Exception;
use app\modules\api\repositories\groups\CreateGroupRepository;
use app\modules\api\repositories\groups\DeleteGroupRepository;

class GroupsController extends Controller
{
    protected $createGroupRepository;
    protected $deleteGroupRepository;

    public function __construct($id, $module, CreateGroupRepository $createGroupRepository, DeleteGroupRepository $deleteGroupRepository, $config = [])
    {
        $this->createGroupRepository = $createGroupRepository;
        $this->deleteGroupRepository = $deleteGroupRepository;
        parent::__construct($id, $module, $config);
    }

    /**
     * create new group
     **/
    public function actionCreate()
    {
        return $this->createGroupRepository->create(Yii::$app->request->post());
    }

    /**
     * delete a group
     **/
    public function actionDelete(int $id)
    {
        return $this->deleteGroupRepository->delete($id);
    }
}
