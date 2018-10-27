<?php
namespace app\modules\api\components\requestsValidators\dependencies;

use Yii;
use yii\base\Model;

abstract class IlluminateRequestValidator extends Model implements RequestValidatorInterface
{
    /**
     * Function that creates the necessary rules array for the form that is being created.
     * In order to be able to set Yii::$app->request->post() in one step using load() function
     * all the attributes of the Form that is being created need to be safe
     * Example: A Form AgeForm has 2 attributes, $name and $age
     * In order to be able to use load(), AgeForm must have one of the rules as
     * [['name','age'],'safe']
     * This allows setting the attributes $name and $age automatically using load()
     * Here this $rules array is being created through iterating through the Form's properties
     * and setting an array of them to be safe
     * @return string
     */
    public function rules() {
        $safeAttributes = [];
        foreach ($this as $key => $value) {
            $safeAttributes [] = $key;
        }

        $safeRule = array($safeAttributes, 'safe');
        $rules = array($safeRule);
        return $rules;
    }

    public function getValidationErrors()
    {
        $errormessages = [];
        $validatorFactory = Yii::$container->get('validatorFactory');
        $validator = $validatorFactory->make(array_filter($this->attributes), $this->rules);
        if ($validator->fails()) {
            Yii::$app->response->statusCode = 422;
            $errors = $validator->errors();
            if ($errors)
                $errormessages = $errors->messages();
        }

        return $errormessages;
    }
}
