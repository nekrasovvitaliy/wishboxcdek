<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use WishboxCdek\Request\RequestData;

final readonly class SenderContactDto extends RequestData
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

    public function withName(string $name): self
    {
        return $this->rebuild(name: $name);
    }

    /**
     * @param list<PhoneDto> $phones
     */
    public function withPhones(array $phones): self
    {
        return $this->rebuild(phones: $phones);
    }

    public function withCompany(string $company): self
    {
        return $this->rebuild(company: $company);
    }

    public function withContragentType(string $contragentType): self
    {
        return $this->rebuild(contragentType: $contragentType);
    }

    public function withPassportSeries(string $passportSeries): self
    {
        return $this->rebuild(passportSeries: $passportSeries);
    }

    public function withPassportNumber(string $passportNumber): self
    {
        return $this->rebuild(passportNumber: $passportNumber);
    }

    public function withPassportDateOfIssue(string $passportDateOfIssue): self
    {
        return $this->rebuild(passportDateOfIssue: $passportDateOfIssue);
    }

    public function withPassportOrganization(string $passportOrganization): self
    {
        return $this->rebuild(passportOrganization: $passportOrganization);
    }

    public function withTin(string $tin): self
    {
        return $this->rebuild(tin: $tin);
    }

    public function withPassportDateOfBirth(string $passportDateOfBirth): self
    {
        return $this->rebuild(passportDateOfBirth: $passportDateOfBirth);
    }

    public function withEmail(string $email): self
    {
        return $this->rebuild(email: $email);
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

    private function rebuild(
        ?string $name = null,
        ?array $phones = null,
        ?string $company = null,
        ?string $contragentType = null,
        ?string $passportSeries = null,
        ?string $passportNumber = null,
        ?string $passportDateOfIssue = null,
        ?string $passportOrganization = null,
        ?string $tin = null,
        ?string $passportDateOfBirth = null,
        ?string $email = null,
        ?bool $passportRequirementsSatisfied = null,
    ): self
    {
        return new self(
            name: $name ?? $this->name,
            phones: $phones ?? $this->phones,
            company: $company ?? $this->company,
            contragentType: $contragentType ?? $this->contragentType,
            passportSeries: $passportSeries ?? $this->passportSeries,
            passportNumber: $passportNumber ?? $this->passportNumber,
            passportDateOfIssue: $passportDateOfIssue ?? $this->passportDateOfIssue,
            passportOrganization: $passportOrganization ?? $this->passportOrganization,
            tin: $tin ?? $this->tin,
            passportDateOfBirth: $passportDateOfBirth ?? $this->passportDateOfBirth,
            email: $email ?? $this->email,
            passportRequirementsSatisfied: $passportRequirementsSatisfied ?? $this->passportRequirementsSatisfied,
        );
    }
}
