<?php
/**
* repository for new user
*/
namespace app\modules\api\repositories\users;

use Yii;
use app\modules\api\models\Users;
use Exception;

class AssignUserToGroupRepository implements AssignUserToGroupRepositoryInterface
{
    protected $model;
    protected $requestValidator;
    protected $successResponse;
    protected $errorResponse;
    protected $getUsersRepository;

    public function __construct()
    {
        $this->getUsersRepository = Yii::$container->get('GetUsersRepository');
        $this->requestValidator = Yii::$container->get('AssignUserToGroupRequestValidator');
        $this->successResponse = Yii::$container->get('SuccessResponse');
        $this->errorResponse = Yii::$container->get('ErrorResponse');
    }

    /**
     *  assign user to group
     * @param Array $params creating params
     * @param int $id of the user
     **/
    public function assign(int $id, Array $params)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->requestValidator->load($params, '');
            if ($requestValidatorError = $this->requestValidator->getValidationErrors()) {
                return $this->errorResponse->getResponse($requestValidatorError);
            } else {
                if ($this->model = $this->getUsersRepository->getOne($id)) {
                    if ($this->model->group_id == $params['group_id']) {
                        throw new Exception('the user already in the group', 1);
                    }
                    $this->model->group_id = $params['group_id'];
                    $this->persist();
                    $transaction->commit();
                    return $this->successResponse->getResponse($this->model);
                } else {
                    throw new Exception("The user in not found!", 1);
                }
            }
        } catch (Exception $e) {
            $transaction->rollBack();
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
}
