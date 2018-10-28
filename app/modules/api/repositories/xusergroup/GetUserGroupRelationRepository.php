<?php
/**
* repository getting user groups relations
*/
namespace app\modules\api\repositories\xusergroup;

use Yii;
use app\modules\api\models\XUserGroup;
use Exception;
use app\modules\api\repositories\GettingRepositoryInterface;

class GetUserGroupRelationRepository
{
    public function getUserAndGroupRel(int $groupId, int $userId)
    {
        $query = XUserGroup::find()->where(['group_id' => $groupId, 'user_id' => $userId]);
        
        return $query->one();
    }
}
