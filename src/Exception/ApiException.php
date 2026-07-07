<?php

declare(strict_types=1);

namespace WishboxCdek\Exception;

use Throwable;

final class ApiException extends CdekException implements ApiExceptionInterface
{
    public function __construct(
        string $message,
        private readonly int $statusCode,
        private readonly object $response,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $statusCode, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getResponse(): object
    {
        return $this->response;
    }
}
