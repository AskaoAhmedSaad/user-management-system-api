<?php
namespace app\modules\api\components\requestsValidators;

use app\modules\api\components\requestsValidators\dependencies\IlluminateRequestValidator;

class XUserGroupRequestValidator extends IlluminateRequestValidator
{
    public $group_id, $user_id;

    public function getRules()
    {
        return [
            'group_id' => 'required|int',
            'user_id' => 'required|int',
        ];
    }

}
