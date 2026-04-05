<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Passport;

final readonly class PassportStatusDto
{
    public function __construct(
        public ?string $client = null,
        public ?bool $passportRequirementsSatisfied = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            client: isset($data['client']) ? (string) $data['client'] : null,
            passportRequirementsSatisfied: isset($data['passport_requirements_satisfied'])
                ? (bool) $data['passport_requirements_satisfied']
                : null,
        );
    }
}
