<?php
/**
 * intrface for any response class
 * */
namespace app\modules\api\components\responses;

interface ResponseInterface
{
	public function getResponse($data);
}