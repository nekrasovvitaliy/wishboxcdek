<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Intake;

use WishboxCdek\Request\RequestData;

final readonly class GetAvailableIntakeDaysRequest extends RequestData
{
    public function __construct(
        public IntakeAvailableDaysLocationDto $fromLocation,
        public ?string $date = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'from_location' => $this->fromLocation,
            'date' => $this->date,
        ]);
    }
}
