<?php
/**
* repository for delete group
*/
namespace app\modules\api\repositories\groups;

use Yii;
use app\modules\api\models\Groups;
use Exception;
use app\modules\api\repositories\DeletingRepositoryInterface;

class DeleteGroupRepository implements DeletingRepositoryInterface
{
    protected $model;
    protected $getGroupsRepository;
    protected $getUsersRepository;
    protected $successResponse;
    protected $errorResponse;

    public function __construct()
    {
        $this->getGroupsRepository = Yii::$container->get('GetGroupsRepository');
        $this->getUsersRepository = Yii::$container->get('GetUsersRepository');
        $this->successResponse = Yii::$container->get('SuccessResponse');
        $this->errorResponse = Yii::$container->get('ErrorResponse');
    }

    /**
     *  delete a group
     * @param int $id of group
     **/
    public function delete(int $id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($this->model = $this->getGroupsRepository->getOne($id)) {
                if ($groupUsers = $this->getUsersRepository->getGroupUsers($id)) {
                    throw new Exception("The group has user and can't be deleted!", 1);                
                } else {
                    $this->model->deleted = true;
                    $this->persist();
                    $transaction->commit();
                    return $this->successResponse->getResponse($this->model);
                }
            }  else {
                throw new Exception("The group in not found!", 1);
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            return $this->errorResponse->getResponse($e->getMessage());
        } 
    }

    /**
     * persist deleting group
     * */
    protected function persist()
    {
        if (!$this->model->save()) {
            throw new Exception('error in creating new ' . get_class($this->model) . ' : ' . current($this->model->getFirstErrors()), 1);
        }
    }
}
