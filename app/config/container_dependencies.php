<?php

return [
    'definitions' => [
      'CreateGroupRepository' => [
          'class' =>  'app\modules\api\repositories\groups\CreateGroupRepository'
       ],
      'CreateUserRepository' => [
           'class' =>  'app\modules\api\repositories\users\CreateUserRepository'
      ],
      'CreateXUserGroupRepository' => [
          'class' =>  'app\modules\api\repositories\xusergroup\CreateXUserGroupRepository'
      ],
      'DeleteUserRepository' => [
          'class' =>  'app\modules\api\repositories\users\DeleteUserRepository'
      ],
      'DeleteXUserGroupRepository' => [
          'class' =>  'app\modules\api\repositories\xusergroup\DeleteXUserGroupRepository'
      ],
      'GetGroupsRepository' => [
           'class' =>  'app\modules\api\repositories\groups\GetGroupsRepository'
      ],
      'GetUsersRepository' => [
           'class' =>  'app\modules\api\repositories\users\GetUsersRepository'
      ],
      'GetUserGroupRelationRepository' => [
           'class' =>  'app\modules\api\repositories\xusergroup\GetUserGroupRelationRepository'
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
      'XUserGroupRequestValidator' => [
          'class' =>  'app\modules\api\components\requestsValidators\XUserGroupRequestValidator'
      ],
      'SuccessResponse' => [
          'class' =>  'app\modules\api\components\responses\SuccessResponse'
      ],
      'ErrorResponse' => [
          'class' =>  'app\modules\api\components\responses\ErrorResponse'
      ],
    ]
];