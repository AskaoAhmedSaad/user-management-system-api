<?php
namespace app\modules\api\components\requestsValidators;

use app\modules\api\components\requestsValidators\dependencies\IlluminateRequestValidator;

class CreateGroupRequestValidator extends IlluminateRequestValidator
{
    public $name;

    public function getRules()
    {
        return [
            'name' => 'required|max:255',
        ];
    }

}
