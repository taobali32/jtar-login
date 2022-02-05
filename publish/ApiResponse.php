<?php

namespace App\Traits;

use Hyperf\Resource\Json\ResourceCollection;
use Hyperf\HttpServer\Contract\ResponseInterface as ApiResponseInterface;
use Psr\Http\Message\ResponseInterface;

trait ApiResponse
{

    /**
     * success
     * @param null $data
     * @param string|null $message
     * @return ResponseInterface
     */
    public function success(string $message = 'success',$data = null): ResponseInterface
    {
        return make(ApiResponseInterface::class)->json(['code' =>  200 , 'data' => empty($data) ? [] : $data, 'message' => $message]);
    }


    /**
     * 返回列表
     * successList
     * @param ResourceCollection $resource
     * @param string $message
     * @return ResourceCollection
     */
    public function successList(ResourceCollection $resource, string $message = 'success'): ResourceCollection
    {
        return $resource->additional([
            'code' => 200,
            'message' => $message,
        ]);
    }

    /**
     * noFond
     * @param string $message
     * @param null $data
     * @return ResponseInterface
     */
    public function noFond(string $message = 'Not Fond!', $data = null): ResponseInterface
    {
        return make(ApiResponseInterface::class)->json(['code' =>  404 , 'data' => $data, 'message' => $message]);
    }

    /**
     * internalError
     * @param string $message
     * @param null $data
     * @return ResponseInterface
     */
    public function internalError(string $message = "Internal Error!", $data = null): ResponseInterface
    {
        return make(ApiResponseInterface::class)->json(['code' =>  500 , 'data' => $data, 'message' => $message]);
    }

    /**
     * failed
     * @param string $message
     * @param int $code
     * @param array $data
     * @return ResponseInterface
     */
    public function failed(string $message = 'failed', int $code = 400, array $data = []): ResponseInterface
    {
        if ($data == []){
            $data = '';
        }

        return make(ApiResponseInterface::class)->json(['code' =>  $code , 'data' => $data, 'message' => $message]);
    }
}