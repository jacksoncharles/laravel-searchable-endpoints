<?php namespace HomeBargain\LaravelRepo\Exceptions;

use Exception;

class RepositoryException extends Exception 
{
    /**
     * @param string  $message
     * @param int $statusCode
     * @param Exception
     * @param array
     */
    public function __construct($message = 'An error occurred inb the repositories', $statusCode = null, $previous = null )
    {
        parent::__construct($message, $statusCode, $previous);
    }
}