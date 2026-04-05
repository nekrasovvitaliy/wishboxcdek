<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Location;

final readonly class SuggestedCityDto
{
    public function __construct(
        public ?string $cityUuid = null,
        public ?int $code = null,
        public ?string $fullName = null,
        public ?string $countryCode = null,
    ) {
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
