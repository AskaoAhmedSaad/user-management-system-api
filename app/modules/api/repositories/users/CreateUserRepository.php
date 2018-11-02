<?php
/**
* repository for new user
*/
namespace app\modules\api\repositories\users;

use Yii;
use app\modules\api\models\Users;
use Exception;
use app\modules\api\repositories\CreatingRepositoryInterface;

class CreateUserRepository implements CreatingRepositoryInterface
{
    protected $model;
    protected $requestValidator;
    protected $successResponse;
    protected $errorResponse;

    public function __construct()
    {
        $this->requestValidator = Yii::$container->get('CreateUserRequestValidator');
        $this->successResponse = Yii::$container->get('SuccessResponse');
        $this->errorResponse = Yii::$container->get('ErrorResponse');
    }

    /**
     *  creating new user 
     * @param Array $params creating params
     **/
    public function create(Array $params)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->requestValidator->load($params, '');
            if ($requestValidatorError = $this->requestValidator->getValidationErrors()) {
                return $this->errorResponse->getResponse($requestValidatorError);
            } else {
                $this->model = new Users;
                $this->model->attributes = $params;
                $this->persist();
                $transaction->commit();
                return $this->successResponse->getResponse($this->model);
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::$app->response->statusCode = 422;
            return $this->errorResponse->getResponse("something wrong happen, please contact the support");
        } 
    }

    /**
     * persist new user
     * */
    protected function persist()
    {
        if (!$this->model->save()) {
            throw new Exception('error in creating new ' . get_class($this->model) . ' : ' . current($this->model->getFirstErrors()), 1);
        }
    }
}
