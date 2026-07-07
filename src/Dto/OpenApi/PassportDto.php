<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: PassportDto
 *
 * Информация о паспортных данных
 */
final readonly class PassportDto
{
    public mixed $client;

    public mixed $passportRequirementsSatisfied;

    public function __construct(
        mixed $client = null,
        mixed $passportRequirementsSatisfied = null,
    ) {
        $this->client = $client;
        $this->passportRequirementsSatisfied = $passportRequirementsSatisfied;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            client: $data['client'] ?? null,
            passportRequirementsSatisfied: $data['passport_requirements_satisfied'] ?? null,
        );
    }
}
