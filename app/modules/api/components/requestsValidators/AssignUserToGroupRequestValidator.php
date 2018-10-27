<?php
namespace app\modules\api\components\requestsValidators;

use app\modules\api\components\requestsValidators\dependencies\IlluminateRequestValidator;

class AssignUserToGroupRequestValidator extends IlluminateRequestValidator
{
    public $name;

    public function getRules()
    {
        return [
            'group_id' => 'int',
        ];
    }

}
