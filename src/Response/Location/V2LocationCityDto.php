<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Location;

final readonly class V2LocationCityDto
{
    /**
     * Код населенного пункта СДЭК.
     */
    public ?int $code;

    /**
     * Идентификатор населенного пункта в ИС СДЭК.
     */
    public ?string $cityUuid;

    /**
     * Название населенного пункта.
     */
    public ?string $city;

    /**
     * Уникальный идентификатор ФИАС населенного пункта.
     */
    public ?string $fiasGuid;

    /**
     * Код КЛАДР населенного пункта.
     */
    public ?string $kladrCode;

    /**
     * Код страны населенного пункта в формате ISO_3166-1_alpha-2.
     */
    public ?string $countryCode;

    /**
     * Название страны населенного пункта.
     */
    public ?string $country;

    /**
     * Название региона населенного пункта.
     */
    public ?string $region;

    /**
     * Код региона СДЭК.
     */
    public ?int $regionCode;

    /**
     * Уникальный идентификатор ФИАС региона населенного пункта. Устаревшее поле.
     */
    public ?string $fiasRegionGuid;

    /**
     * Код КЛАДР региона.
     */
    public ?string $kladrRegionCode;

    /**
     * Название района региона населенного пункта.
     */
    public ?string $subRegion;

    /**
     * Долгота центра населенного пункта.
     */
    public ?float $longitude;

    /**
     * Широта центра населенного пункта.
     */
    public ?float $latitude;

    /**
     * Часовой пояс населенного пункта.
     */
    public ?string $timeZone;

    /**
     * Ограничение на сумму наложенного платежа в населенном пункте.
     * Особые значения: -1 - ограничения нет; 0 - наложенный платеж не принимается.
     */
    public ?float $paymentLimit;

    /**
     * Почтовый индекс.
     */
    public ?string $postalCode;

    public function __construct(
        ?int $code = null,
        ?string $cityUuid = null,
        ?string $city = null,
        ?string $fiasGuid = null,
        ?string $kladrCode = null,
        ?string $countryCode = null,
        ?string $country = null,
        ?string $region = null,
        ?int $regionCode = null,
        ?string $fiasRegionGuid = null,
        ?string $kladrRegionCode = null,
        ?string $subRegion = null,
        ?float $longitude = null,
        ?float $latitude = null,
        ?string $timeZone = null,
        ?float $paymentLimit = null,
        ?string $postalCode = null,
    ) {
        $this->code = $code;
        $this->cityUuid = $cityUuid;
        $this->city = $city;
        $this->fiasGuid = $fiasGuid;
        $this->kladrCode = $kladrCode;
        $this->countryCode = $countryCode;
        $this->country = $country;
        $this->region = $region;
        $this->regionCode = $regionCode;
        $this->fiasRegionGuid = $fiasRegionGuid;
        $this->kladrRegionCode = $kladrRegionCode;
        $this->subRegion = $subRegion;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->timeZone = $timeZone;
        $this->paymentLimit = $paymentLimit;
        $this->postalCode = $postalCode;
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
            kladrCode: isset($data['kladr_code']) ? (string) $data['kladr_code'] : null,
            countryCode: isset($data['country_code']) ? (string) $data['country_code'] : null,
            country: isset($data['country']) ? (string) $data['country'] : null,
            region: isset($data['region']) ? (string) $data['region'] : null,
            regionCode: isset($data['region_code']) ? (int) $data['region_code'] : null,
            fiasRegionGuid: isset($data['fias_region_guid']) ? (string) $data['fias_region_guid'] : null,
            kladrRegionCode: isset($data['kladr_region_code']) ? (string) $data['kladr_region_code'] : null,
            subRegion: isset($data['sub_region']) ? (string) $data['sub_region'] : null,
            longitude: isset($data['longitude']) ? (float) $data['longitude'] : null,
            latitude: isset($data['latitude']) ? (float) $data['latitude'] : null,
            timeZone: isset($data['time_zone']) ? (string) $data['time_zone'] : null,
            paymentLimit: isset($data['payment_limit']) ? (float) $data['payment_limit'] : null,
            postalCode: isset($data['postal_code']) ? (string) $data['postal_code'] : null,
        );
    }
}
