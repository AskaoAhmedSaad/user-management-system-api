<?php
/**
* repository getting branches
*/
namespace app\modules\api\repositories\groups;

use Yii;
use app\modules\api\models\Groups;
use Exception;
use app\modules\api\repositories\GettingRepositoryInterface;

class GetGroupsRepository implements GettingRepositoryInterface
{

    public function getAll()
    {
        $query = Groups::find()->where(['deleted' => 0]);
        
        return $query->all();
    }

    public function getOne(int $id)
    {
        $query = Groups::find()->where(['id' => $id, 'deleted' => 0]);
        
        return $query->one();
    }
}
