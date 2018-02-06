<?php

namespace App\Traits;

/**
 * Api Response
 */
trait ApiResponse
{

    protected function success($message)
    {
        return response(array_merge($this->defaultResult, [
            'code' => 0,
            'message' => $message,
        ]));
    }

    protected function successWithData($data, $message = '')
    {
        return response(array_merge($this->defaultResult, [
            'code' => 0,
            'message' => $message,
            'data' => $data,
        ]));
    }

    protected function successWithDataAndPermission($data,$message = '',$permission)
    {
        return response(array_merge($this->defaultResult, [
            'code' => 0,
            'message' => $message,
            'data' => $data,
            'permission' => $permission
        ]));
    }

    protected function fail($message)
    {
        return response(array_merge($this->defaultResult, [
            'code' => 1,
            'message' => $message,
        ]));
    }

    protected function error($code, $errorMessage = '', $data = null)
    {
        return response(array_merge($this->defaultResult, [
            'code' => $code,
            'message' => $errorMessage,
            'data' => $data,
        ]), $code);
    }

    protected function errorAsBadRequest($data)
    {
        return $this->error(400, '请求参数不正确', $data);
    }

    protected $defaultResult = [
        'code' => null,
        'message' => null,
        'data' => null,
    ];
}
