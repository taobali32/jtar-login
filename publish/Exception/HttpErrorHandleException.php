<?php


namespace App\Exception;

use Hyperf\Server\Exception\ServerException;
use Throwable;

class HttpErrorHandleException extends ServerException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}