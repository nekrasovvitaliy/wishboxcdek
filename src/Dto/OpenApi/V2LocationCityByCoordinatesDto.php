<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: V2LocationCityByCoordinatesDto
 *
 * Транспорт ответа на запрос получения списка населенных пунктов
 */
final readonly class V2LocationCityByCoordinatesDto
{
    public ?int $code;

    public ?string $cityUuid;

    public ?string $city;

    public ?string $fiasGuid;

    public function __construct(
        ?int $code = null,
        ?string $cityUuid = null,
        ?string $city = null,
        ?string $fiasGuid = null,
    ) {
        $this->code = $code;
        $this->cityUuid = $cityUuid;
        $this->city = $city;
        $this->fiasGuid = $fiasGuid;
    }

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
