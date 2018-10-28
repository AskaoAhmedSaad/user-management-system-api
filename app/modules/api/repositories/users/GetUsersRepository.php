<?php
/**
* repository getting users
*/
namespace app\modules\api\repositories\users;

use Yii;
use app\modules\api\models\Users;
use Exception;
use app\modules\api\repositories\GettingRepositoryInterface;

class GetUsersRepository implements GettingRepositoryInterface
{

    public function getAll()
    {
        $query = Users::find()->where(['deleted' => 0]);
        
        return $query->all();
    }

    public function getOne(int $id)
    {
        $query = Users::find()->where(['id' => $id, 'deleted' => 0]);
        
        return $query->one();
    }
}
