<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: NearestCityDto
 *
 * Транспорт ближайшего найденного города
 */
final readonly class NearestCityDto
{
    public ?string $code;

    public ?string $name;

    public ?string $fullName;

    public ?float $latitude;

    public ?float $longitude;

    public ?float $distance;

    public function __construct(
        ?string $code = null,
        ?string $name = null,
        ?string $fullName = null,
        ?float $latitude = null,
        ?float $longitude = null,
        ?float $distance = null,
    ) {
        $this->code = $code;
        $this->name = $name;
        $this->fullName = $fullName;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->distance = $distance;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: isset($data['code']) ? (string) $data['code'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            fullName: isset($data['fullName']) ? (string) $data['fullName'] : null,
            latitude: isset($data['latitude']) ? (float) $data['latitude'] : null,
            longitude: isset($data['longitude']) ? (float) $data['longitude'] : null,
            distance: isset($data['distance']) ? (float) $data['distance'] : null,
        );
    }
}
