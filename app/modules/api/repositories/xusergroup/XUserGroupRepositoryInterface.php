<?php
/**
* interface for assigning user to group
* */

namespace app\modules\api\repositories\xusergroup;

interface XUserGroupRepositoryInterface
{
    public function assign(Array $params);
    
    public function remove(Array $params);
}
