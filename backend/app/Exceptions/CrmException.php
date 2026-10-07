<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * CrmException
 *
 * Base exception class for all domain-level CRM exceptions.
 * Domain modules should extend this or use module-specific subclasses.
 */
class CrmException extends RuntimeException
{
    protected string $errorCode;

    public function __construct(
        string $message = 'A CRM error occurred.',
        string $errorCode = 'crm_error',
        int    $httpStatus = 400,
        ?\Throwable $previous = null
    ) {
        $this->errorCode = $errorCode;
        parent::__construct($message, $httpStatus, $previous);
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getHttpStatus(): int
    {
        return $this->getCode();
    }
}
