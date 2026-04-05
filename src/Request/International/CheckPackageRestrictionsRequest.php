<?php

declare(strict_types=1);

namespace WishboxCdek\Request\International;

use WishboxCdek\Request\RequestData;

final readonly class CheckPackageRestrictionsRequest extends RequestData
{
    /**
     * @param list<RestrictionPackageRequestDto> $packages
     */
    public function __construct(
        public int $tariffCode,
        public LocationDto $fromLocation,
        public LocationDto $toLocation,
        public array $packages,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'tariff_code' => $this->tariffCode,
            'from_location' => $this->fromLocation,
            'to_location' => $this->toLocation,
            'packages' => $this->packages,
        ]);
    }
}
