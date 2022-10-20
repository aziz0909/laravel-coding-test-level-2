<?php

namespace App\Http\Traits;

/**
 *
 */
trait ApiResponse
{
    protected function successResponse($data, $message = null, $code = 200)
	{
		return response()->json([
			'status'=> 'Success',
			'message' => $message,
			'data' => $data
		], $code);
	}

	protected function errorResponse($message = null, $code = 400)
	{
		return response()->json([
			'status'=>'Error',
			'message' => $message,
			'statusText' => $message,
			'data' => null
		], $code);
	}

	protected function customResponse($data, $message = null, $status='Success', $code = 200)
	{
		return response()->json([
			'status'=> $status,
			'message' => $message,
			'data' => $data
		], $code);
	}
}
