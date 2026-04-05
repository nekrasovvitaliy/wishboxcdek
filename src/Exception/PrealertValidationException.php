<?php

declare(strict_types=1);

namespace WishboxCdek\Exception;

final class PrealertValidationException extends CdekException
{
    /**
     * @param list<string> $errors
     */
    public function __construct(
        private readonly array $errors,
    ) {
        parent::__construct($errors === [] ? 'Prealert request validation failed.' : implode('; ', $errors));
    }

    /**
     * @return list<string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
