<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use Exception;
use app\modules\api\repositories\xusergroup\XUserGroupRepositoryInterface;

class XUserGroupController extends Controller
{
    protected $xUserGroupRepository;

    public function __construct($id, $module, XUserGroupRepositoryInterface $xUserGroupRepository, $config = [])
    {
        $this->xUserGroupRepository = $xUserGroupRepository;
        parent::__construct($id, $module, $config);
    }

    /**
     * assign user to group
     **/
    public function actionAssignToGroup()
    {
        return $this->xUserGroupRepository->assign(Yii::$app->request->post());
    }

    /**
     * remove user from group
     **/
    public function actionRemoveFromGroup()
    {
        return $this->xUserGroupRepository->remove(Yii::$app->request->post());
    }

}
