<?php
/**
* repository for new group
*/
namespace app\modules\api\repositories\groups;

use Yii;
use app\modules\api\models\Groups;
use Exception;
use app\modules\api\repositories\CreatingRepositoryInterface;

class CreateGroupRepository implements CreatingRepositoryInterface
{
    protected $model;
    protected $requestValidator;
    protected $successResponse;
    protected $errorResponse;

    public function __construct()
    {
        $this->requestValidator = Yii::$container->get('CreateGroupRequestValidator');
        $this->successResponse = Yii::$container->get('SuccessResponse');
        $this->errorResponse = Yii::$container->get('ErrorResponse');
    }

    /**
     *  creating new group 
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
                $this->model = new Groups;
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
     * persist new group
     * */
    protected function persist()
    {
        if (!$this->model->save()) {
            throw new Exception('error in creating new ' . get_class($this->model) . ' : ' . current($this->model->getFirstErrors()), 1);
        }
    }
}
