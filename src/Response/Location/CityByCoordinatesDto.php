<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Location;

final readonly class CityByCoordinatesDto
{
    public function __construct(
        public ?int $code,
        public ?string $cityUuid,
        public ?string $city,
        public ?string $fiasGuid,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: isset($data['code']) ? (int) $data['code'] : null,
            cityUuid: isset($data['city_uuid']) ? (string) $data['city_uuid'] : null,
            city: isset($data['city']) ? (string) $data['city'] : null,
            fiasGuid: isset($data['fias_guid']) ? (string) $data['fias_guid'] : null,
        );
    }
}
