<?php
/**
* interface for any creating repositories
*/
namespace app\modules\api\repositories;


interface CreatingRepositoryInterface
{
    public function create(Array $params);
}
