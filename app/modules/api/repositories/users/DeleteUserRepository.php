<?php
/**
* repository for delete user
*/
namespace app\modules\api\repositories\users;

use Yii;
use app\modules\api\models\Users;
use Exception;
use app\modules\api\repositories\DeletingRepositoryInterface;

class DeleteUserRepository implements DeletingRepositoryInterface
{
    protected $model;
    protected $getUsersRepository;
    protected $successResponse;
    protected $errorResponse;

    public function __construct()
    {
        $this->getUsersRepository = Yii::$container->get('GetUsersRepository');
        $this->successResponse = Yii::$container->get('SuccessResponse');
        $this->errorResponse = Yii::$container->get('ErrorResponse');
    }

    /**
     *  delete a user
     * @param int $id of user
     **/
    public function delete(int $id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($this->model = $this->getUsersRepository->getOne($id)) {
                $this->model->deleted = true;
                $this->persist();
                $transaction->commit();
                return $this->successResponse->getResponse($this->model);
            } else {
                $transaction->rollBack();
                throw new Exception("The user in not found!", 1);
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::$app->response->statusCode = 422;
            return $this->errorResponse->getResponse("something wrong happen, please contact the support");
        } 
    }

    /**
     * persist deleting user
     * */
    protected function persist()
    {
        if (!$this->model->save()) {
            throw new Exception('error in creating new ' . get_class($this->model) . ' : ' . current($this->model->getFirstErrors()), 1);
        }
    }
}
