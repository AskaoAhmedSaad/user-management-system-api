<?php
/**
 * return error response
 * */
namespace app\modules\api\components\responses;

class ErrorResponse implements ResponseInterface
{
	public function getResponse($data)
	{
		return [
			"error" => true,
			"data" => $data
		];
	}
}