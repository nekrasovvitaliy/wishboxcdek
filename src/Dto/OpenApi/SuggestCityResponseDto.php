<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: SuggestCityResponseDto
 *
 * Транспорт ответа подбора города по названию
 */
final readonly class SuggestCityResponseDto
{
    public ?string $cityUuid;

    public ?int $code;

    public ?string $fullName;

    public ?string $countryCode;

    public function __construct(
        ?string $cityUuid = null,
        ?int $code = null,
        ?string $fullName = null,
        ?string $countryCode = null,
    ) {
        $this->cityUuid = $cityUuid;
        $this->code = $code;
        $this->fullName = $fullName;
        $this->countryCode = $countryCode;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            cityUuid: isset($data['city_uuid']) ? (string) $data['city_uuid'] : null,
            code: isset($data['code']) ? (int) $data['code'] : null,
            fullName: isset($data['full_name']) ? (string) $data['full_name'] : null,
            countryCode: isset($data['country_code']) ? (string) $data['country_code'] : null,
        );
    }
}
