<?php

return [
    'definitions' => [
      'CreateGroupRepository' => [
          'class' =>  'app\modules\api\repositories\groups\CreateGroupRepository'
       ],
      'CreateUserRepository' => [
           'class' =>  'app\modules\api\repositories\users\CreateUserRepository'
      ],
      'GetGroupsRepository' => [
           'class' =>  'app\modules\api\repositories\groups\GetGroupsRepository'
      ],
      'GetUsersRepository' => [
           'class' =>  'app\modules\api\repositories\users\GetUsersRepository'
      ],
      'app\modules\api\repositories\users\AssignUserToGroupRepositoryInterface' => [
          'class' =>  'app\modules\api\repositories\users\AssignUserToGroupRepository'
      ],
      'validatorFactory' => [
          'class' =>  'app\modules\api\components\requestsValidators\dependencies\ValidatorFactory'
      ],
      'CreateGroupRequestValidator' => [
          'class' =>  'app\modules\api\components\requestsValidators\CreateGroupRequestValidator'
      ],
      'CreateUserRequestValidator' => [
          'class' =>  'app\modules\api\components\requestsValidators\CreateUserRequestValidator'
      ],
      'AssignUserToGroupRequestValidator' => [
          'class' =>  'app\modules\api\components\requestsValidators\AssignUserToGroupRequestValidator'
      ],
      'SuccessResponse' => [
          'class' =>  'app\modules\api\components\responses\SuccessResponse'
      ],
      'ErrorResponse' => [
          'class' =>  'app\modules\api\components\responses\ErrorResponse'
      ],
    ]
];