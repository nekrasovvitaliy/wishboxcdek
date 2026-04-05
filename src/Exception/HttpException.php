<?php

declare(strict_types=1);

namespace WishboxCdek\Exception;

use Throwable;
use WishboxCdek\Response\Error\CdekMessage;

final class HttpException extends CdekException
{
    /**
     * @param list<CdekMessage> $errors
     * @param list<CdekMessage> $warnings
     */
    public function __construct(
        string $message,
        private readonly int $statusCode = 0,
        private readonly array $response = [],
        private readonly array $errors = [],
        private readonly array $warnings = [],
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $statusCode, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * @return list<CdekMessage>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return list<CdekMessage>
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }
}
