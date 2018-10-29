<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use Exception;
use app\modules\api\repositories\xusergroup\CreateXUserGroupRepository;
use app\modules\api\repositories\xusergroup\DeleteXUserGroupRepository;

class XUserGroupController extends Controller
{
    protected $createXUserGroupRepository;
    protected $deleteXUserGroupRepository;

    public function __construct($id, $module, CreateXUserGroupRepository $createXUserGroupRepository, 
                                    DeleteXUserGroupRepository $deleteXUserGroupRepository, $config = [])
    {
        $this->createXUserGroupRepository = $createXUserGroupRepository;
        $this->deleteXUserGroupRepository = $deleteXUserGroupRepository;
        parent::__construct($id, $module, $config);
    }

    /**
     * assign user to group
     **/
    public function actionCreate()
    {
        return $this->createXUserGroupRepository->create(Yii::$app->request->post());
    }

    /**
     * remove user from group
     **/
    public function actionRemoveFromGroup()
    {
        return $this->deleteXUserGroupRepository->remove(Yii::$app->request->post());
    }

}
