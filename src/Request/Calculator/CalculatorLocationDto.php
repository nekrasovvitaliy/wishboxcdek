<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Calculator;

use WishboxCdek\Request\RequestData;

final readonly class CalculatorLocationDto extends RequestData
{
    public function __construct(
        public ?int $code = null,
        public ?string $postalCode = null,
        public ?string $countryCode = null,
        public ?string $city = null,
        public ?string $address = null,
        public ?string $contragentType = null,
        public string|float|null $longitude = null,
        public string|float|null $latitude = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'code' => $this->code,
            'postal_code' => $this->postalCode,
            'country_code' => $this->countryCode,
            'city' => $this->city,
            'address' => $this->address,
            'contragent_type' => $this->contragentType,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
        ]);
    }
}
