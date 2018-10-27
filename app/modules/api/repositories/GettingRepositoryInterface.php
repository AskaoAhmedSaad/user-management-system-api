<?php
/**
* interface for any creating repositories
*/
namespace app\modules\api\repositories;


interface GettingRepositoryInterface
{
    public function getAll();

    public function getOne(int $id);
}
