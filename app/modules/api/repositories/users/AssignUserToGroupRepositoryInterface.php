<?php
/**
* interface for assigning user to group
* */

namespace app\modules\api\repositories\users;

interface AssignUserToGroupRepositoryInterface
{
    public function assign(Array $params);
}
