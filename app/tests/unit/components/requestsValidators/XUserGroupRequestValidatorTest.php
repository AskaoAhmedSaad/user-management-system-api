<?php

namespace tests\components\requestsValidators;

use Yii;
use yii\codeception\TestCase;
use Codeception\Specify;

class XUserGroupRequestValidatorTest extends TestCase
{
    use Specify;
    protected $xUserGroupRequestValidator;
    
    protected function setUp()
    {
        parent::setUp();
        $this->xUserGroupRequestValidator = Yii::$container->get('XUserGroupRequestValidator');
    }

    public function testGetValidationErrors()
    {
        $this->specify("test getValidationErrors() with valid params");
        $this->xUserGroupRequestValidator->load([
                    'group_id' => 1,
                    'user_id' => 1
                ], '');
        $requestValidatorErrors = $this->xUserGroupRequestValidator->getValidationErrors();
        $this->assertEmpty($requestValidatorErrors);
        $this->assertInternalType('array', $requestValidatorErrors);

        $this->specify("test getValidationErrors() with Invalid params");
        $this->xUserGroupRequestValidator->load([
                    'group_id' => null,
                    'user_id' => 1
                ], '');
        $requestValidatorErrors = $this->xUserGroupRequestValidator->getValidationErrors();
        $this->assertInternalType('array', $requestValidatorErrors);
        $this->assertNotEmpty($requestValidatorErrors);
        $this->assertTrue($requestValidatorErrors['group_id'][0] == 'The group id field is required.');

        $this->xUserGroupRequestValidator->load([
                    'group_id' => 'ffff',
                    'user_id' => 1
                ], '');
        $requestValidatorErrors = $this->xUserGroupRequestValidator->getValidationErrors();
        $this->assertInternalType('array', $requestValidatorErrors);
        $this->assertNotEmpty($requestValidatorErrors);
        $this->assertTrue($requestValidatorErrors['group_id'][0] == 'The group id must be an integer.');
    }
}