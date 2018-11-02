<?php
/**
* repository for delete XUserGroup (removing user from group)
*/
namespace app\modules\api\repositories\xusergroup;

use Yii;
use app\modules\api\models\XUserGroup;
use Exception;

class DeleteXUserGroupRepository
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
            return $this->errorResponse->getResponse("something wrong happen, please contact the support");
        } 
    }
}
