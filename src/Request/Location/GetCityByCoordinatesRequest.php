<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Location;

use WishboxCdek\Request\RequestData;

final readonly class GetCityByCoordinatesRequest extends RequestData
{
    public function __construct(
        public float $longitude,
        public float $latitude
    ) {
    }

    public function toArray(): array
    {
        return [
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
        ];
    }
}
