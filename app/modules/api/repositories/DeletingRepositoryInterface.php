<?php
/**
* interface for any deleting repositories
*/
namespace app\modules\api\repositories;


interface DeletingRepositoryInterface
{
    public function delete(int $id);
}
