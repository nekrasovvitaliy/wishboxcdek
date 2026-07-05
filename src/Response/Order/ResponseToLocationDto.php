<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class ResponseToLocationDto
{
    public function __construct(
        public ?int $code = null,
        public ?string $cityUuid = null,
        public ?string $city = null,
        public ?string $fiasGuid = null,
        public ?string $kladrCode = null,
        public ?string $countryCode = null,
        public ?string $country = null,
        public ?string $region = null,
        public ?int $regionCode = null,
        public ?string $fiasRegionGuid = null,
        public ?string $subRegion = null,
        public ?float $longitude = null,
        public ?float $latitude = null,
        public ?string $timeZone = null,
        public int|float|null $paymentLimit = null,
        public ?string $address = null,
        public ?string $postalCode = null,
    ) {
    }

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
            subRegion: isset($data['sub_region']) ? (string) $data['sub_region'] : null,
            longitude: isset($data['longitude']) ? (float) $data['longitude'] : null,
            latitude: isset($data['latitude']) ? (float) $data['latitude'] : null,
            timeZone: isset($data['time_zone']) ? (string) $data['time_zone'] : null,
            paymentLimit: isset($data['payment_limit']) ? (is_int($data['payment_limit']) ? $data['payment_limit'] : (float) $data['payment_limit']) : null,
            address: isset($data['address']) ? (string) $data['address'] : null,
            postalCode: isset($data['postal_code']) ? (string) $data['postal_code'] : null,
        );
    }
}
