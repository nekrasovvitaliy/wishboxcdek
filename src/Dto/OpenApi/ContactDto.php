<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: ContactDto
 *
 * Данные контрагента
 */
final readonly class ContactDto
{
    public mixed $company;

    public mixed $name;

    public mixed $contragentType;

    public mixed $passportSeries;

    public mixed $passportNumber;

    public ?string $passportDateOfIssue;

    public mixed $passportOrganization;

    public mixed $tin;

    public ?string $passportDateOfBirth;

    public mixed $email;

    /**
     * @var list<PhoneDto>
     */
    public array $phones;

    public mixed $passportRequirementsSatisfied;

    public function __construct(
        mixed $company = null,
        mixed $name = null,
        mixed $contragentType = null,
        mixed $passportSeries = null,
        mixed $passportNumber = null,
        ?string $passportDateOfIssue = null,
        mixed $passportOrganization = null,
        mixed $tin = null,
        ?string $passportDateOfBirth = null,
        mixed $email = null,
        array $phones = [],
        mixed $passportRequirementsSatisfied = null,
    ) {
        $this->company = $company;
        $this->name = $name;
        $this->contragentType = $contragentType;
        $this->passportSeries = $passportSeries;
        $this->passportNumber = $passportNumber;
        $this->passportDateOfIssue = $passportDateOfIssue;
        $this->passportOrganization = $passportOrganization;
        $this->tin = $tin;
        $this->passportDateOfBirth = $passportDateOfBirth;
        $this->email = $email;
        $this->phones = $phones;
        $this->passportRequirementsSatisfied = $passportRequirementsSatisfied;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            company: $data['company'] ?? null,
            name: $data['name'] ?? null,
            contragentType: $data['contragent_type'] ?? null,
            passportSeries: $data['passport_series'] ?? null,
            passportNumber: $data['passport_number'] ?? null,
            passportDateOfIssue: isset($data['passport_date_of_issue']) ? (string) $data['passport_date_of_issue'] : null,
            passportOrganization: $data['passport_organization'] ?? null,
            tin: $data['tin'] ?? null,
            passportDateOfBirth: isset($data['passport_date_of_birth']) ? (string) $data['passport_date_of_birth'] : null,
            email: $data['email'] ?? null,
            phones: isset($data['phones']) && is_array($data['phones'])
                ? array_map(
                    static fn (array $phone): PhoneDto => PhoneDto::fromArray($phone),
                    $data['phones'],
                )
                : [],
            passportRequirementsSatisfied: $data['passport_requirements_satisfied'] ?? null,
        );
    }
}
