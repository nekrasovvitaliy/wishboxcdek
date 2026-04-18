<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use InvalidArgumentException;
use WishboxCdek\Request\RequestData;

final readonly class RequestToLocationDto extends RequestData
{
    public function __construct(
        public string $address,
        public ?int $code = null,
        public ?string $cityUuid = null,
        public ?string $city = null,
        public ?string $fiasGuid = null,
        public ?string $countryCode = null,
        public ?string $country = null,
        public ?string $region = null,
        public ?int $regionCode = null,
        public ?string $fiasRegionGuid = null,
        public ?string $kladrRegionCode = null,
        public ?string $subRegion = null,
        public ?float $longitude = null,
        public ?float $latitude = null,
        public ?string $timeZone = null,
        public int|float|null $paymentLimit = null,
        public ?string $postalCode = null,
    ) {
        if (trim($this->address) === '') {
            throw new InvalidArgumentException('RequestToLocationDto expects address to be a non-empty string.');
        }

        if (mb_strlen($this->address) > 255) {
            throw new InvalidArgumentException('RequestToLocationDto expects address to be at most 255 characters long.');
        }
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'code' => $this->code,
            'city_uuid' => $this->cityUuid,
            'city' => $this->city,
            'fias_guid' => $this->fiasGuid,
            'country_code' => $this->countryCode,
            'country' => $this->country,
            'region' => $this->region,
            'region_code' => $this->regionCode,
            'fias_region_guid' => $this->fiasRegionGuid,
            'kladr_region_code' => $this->kladrRegionCode,
            'sub_region' => $this->subRegion,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'time_zone' => $this->timeZone,
            'payment_limit' => $this->paymentLimit,
            'address' => $this->address,
            'postal_code' => $this->postalCode,
        ]);
    }
}
