<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use WishboxCdek\Request\RequestData;

final readonly class RecipientContactDto extends RequestData
{
    /**
     * @var list<PhoneDto>
     */
    public array $phones;

    /**
     * @param list<PhoneDto> $phones
     */
    public function __construct(
        public string $name,
        array $phones,
        public ?string $company = null,
        public ?string $contragentType = null,
        public ?string $passportSeries = null,
        public ?string $passportNumber = null,
        public ?string $passportDateOfIssue = null,
        public ?string $passportOrganization = null,
        public ?string $tin = null,
        public ?string $passportDateOfBirth = null,
        public ?string $email = null,
        public ?bool $passportRequirementsSatisfied = null,
    ) {
        $this->phones = self::validateList($phones, PhoneDto::class, self::class, 'phones');
    }

    /**
     * @param list<PhoneDto> $phones
     */
    public static function make(string $name, array $phones): self
    {
        return new self(
            name: $name,
            phones: $phones,
        );
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'company' => $this->company,
            'name' => $this->name,
            'contragent_type' => $this->contragentType,
            'passport_series' => $this->passportSeries,
            'passport_number' => $this->passportNumber,
            'passport_date_of_issue' => $this->passportDateOfIssue,
            'passport_organization' => $this->passportOrganization,
            'tin' => $this->tin,
            'passport_date_of_birth' => $this->passportDateOfBirth,
            'email' => $this->email,
            'phones' => $this->phones,
            'passport_requirements_satisfied' => $this->passportRequirementsSatisfied,
        ]);
    }
}
