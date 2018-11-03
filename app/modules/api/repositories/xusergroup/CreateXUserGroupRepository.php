<?php
/**
* repository for new XUserGroup (assignning user to group)
*/
namespace app\modules\api\repositories\xusergroup;

use Yii;
use app\modules\api\models\XUserGroup;
use Exception;
use app\modules\api\repositories\CreatingRepositoryInterface;

class CreateXUserGroupRepository implements CreatingRepositoryInterface
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
    public function create(Array $params)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->requestValidator->load($params, '');
            if ($requestValidatorError = $this->requestValidator->getValidationErrors()) {
                return $this->errorResponse->getResponse($requestValidatorError);
            } else {
                if ($this->model = $this->getUserGroupRelationRepository->getUserAndGroupRel($params['group_id'], $params['user_id'])) {
                    $transaction->rollBack();
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
            return $this->errorResponse->getResponse("something wrong happen, please contact the support");
        } 
    }

    /**
     * save the new XUserGroup
     * */
    protected function persist()
    {
        if (!$this->model->save()) {
            throw new Exception('error in creating new ' . get_class($this->model) . ' : ' . current($this->model->getFirstErrors()), 1);
        }
    }
}
