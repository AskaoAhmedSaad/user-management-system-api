<?php
/**
* repository for new user
*/
namespace app\modules\api\repositories\xusergroup;

use Yii;
use app\modules\api\models\XUserGroup;
use Exception;

class XUserGroupRepository implements XUserGroupRepositoryInterface
{
    protected $model;
    protected $requestValidator;
    protected $successResponse;
    protected $errorResponse;
    protected $getUserGroupRelationRepository;

    public function __construct()
    {
        $this->getUserGroupRelationRepository = Yii::$container->get('GetUserGroupRelationRepository');
        $this->requestValidator = Yii::$container->get('XUserGroupRequestValidator');
        $this->successResponse = Yii::$container->get('SuccessResponse');
        $this->errorResponse = Yii::$container->get('ErrorResponse');
    }

    /**
     *  assign user to group
     * @param Array $params assigning params
     **/
    public function assign(Array $params)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->requestValidator->load($params, '');
            if ($requestValidatorError = $this->requestValidator->getValidationErrors()) {
                return $this->errorResponse->getResponse($requestValidatorError);
            } else {
                if ($this->model = $this->getUserGroupRelationRepository->getUserAndGroupRel($params['group_id'], $params['user_id'])) {
                    throw new Exception('the user already in the group', 1);
                } else {
                    $this->model = new XUserGroup;
                    $this->model->group_id = $params['group_id'];
                    $this->model->user_id = $params['user_id'];
                    $this->persist();
                    $transaction->commit();
                    return $this->successResponse->getResponse($this->model);
                }
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::$app->response->statusCode = 422;
            return $this->errorResponse->getResponse($e->getMessage());
        } 
    }

    /**
     * persist changes on user
     * */
    protected function persist()
    {
        if (!$this->model->save()) {
            throw new Exception('error in creating new ' . get_class($this->model) . ' : ' . current($this->model->getFirstErrors()), 1);
        }
    }

    /**
     *  remove user from group
     * @param Array $params removing params
     **/
    public function remove(Array $params)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->requestValidator->load($params, '');
            if ($requestValidatorError = $this->requestValidator->getValidationErrors()) {
                return $this->errorResponse->getResponse($requestValidatorError);
            } else {
                if ($this->model = $this->getUserGroupRelationRepository->getUserAndGroupRel($params['group_id'], $params['user_id'])) {
                    if (!$this->model->delete()) {
                        throw new Exception('error in deleting ' . get_class($this->model) . ' : ' . current($this->model->getFirstErrors()), 1);
                    }
                    $transaction->commit();
                    return $this->successResponse->getResponse($this->model);
                } else {
                    throw new Exception('this user is not in this group', 1);
                }
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::$app->response->statusCode = 422;
            return $this->errorResponse->getResponse($e->getMessage());
        } 
    }
}
