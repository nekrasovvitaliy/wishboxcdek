<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class RecipientResponseContactDto
{
    /**
     * @param list<PhoneDto> $phones
     */
    public function __construct(
        public ?string $company = null,
        public ?string $name = null,
        public ?string $contragentType = null,
        public ?string $passportSeries = null,
        public ?string $passportNumber = null,
        public ?string $passportDateOfIssue = null,
        public ?string $passportOrganization = null,
        public ?string $tin = null,
        public ?string $passportDateOfBirth = null,
        public ?string $email = null,
        public array $phones = [],
        public ?bool $passportRequirementsSatisfied = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $phones = [];

        if (isset($data['phones']) && is_array($data['phones'])) {
            foreach ($data['phones'] as $phone) {
                if (is_array($phone)) {
                    $phones[] = PhoneDto::fromArray($phone);
                }
            }
        }

        return new self(
            company: isset($data['company']) ? (string) $data['company'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            contragentType: isset($data['contragent_type']) ? (string) $data['contragent_type'] : null,
            passportSeries: isset($data['passport_series']) ? (string) $data['passport_series'] : null,
            passportNumber: isset($data['passport_number']) ? (string) $data['passport_number'] : null,
            passportDateOfIssue: isset($data['passport_date_of_issue']) ? (string) $data['passport_date_of_issue'] : null,
            passportOrganization: isset($data['passport_organization']) ? (string) $data['passport_organization'] : null,
            tin: isset($data['tin']) ? (string) $data['tin'] : null,
            passportDateOfBirth: isset($data['passport_date_of_birth']) ? (string) $data['passport_date_of_birth'] : null,
            email: isset($data['email']) ? (string) $data['email'] : null,
            phones: $phones,
            passportRequirementsSatisfied: isset($data['passport_requirements_satisfied']) ? (bool) $data['passport_requirements_satisfied'] : null,
        );
    }
}
