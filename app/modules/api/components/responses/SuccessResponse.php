<?php
/**
 * return success response
 * */
namespace app\modules\api\components\responses;

class SuccessResponse implements ResponseInterface
{
	public function getResponse($data)
	{
		return [
			"success" => true,
			"data" => $data,

		];
	}
}