<?php

declare(strict_types=1);

namespace WishboxCdek\Exception;

use Throwable;
use WishboxCdek\Response\Error\CdekMessage;

final class ApiResponseException extends CdekException
{
    /**
     * @param list<CdekMessage> $errors
     * @param list<CdekMessage> $warnings
     * @param list<string> $requestStates
     */
    public function __construct(
        string $message,
        private readonly array $response = [],
        private readonly array $errors = [],
        private readonly array $warnings = [],
        private readonly array $requestStates = [],
        ?Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
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

    /**
     * @return list<string>
     */
    public function getRequestStates(): array
    {
        return $this->requestStates;
    }
}
