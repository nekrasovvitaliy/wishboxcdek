<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class StatusDto
{
    public function __construct(
        public ?int $code = null,
        public ?string $name = null,
        public ?string $dateTime = null,
        public ?int $reasonCode = null,
        public ?string $city = null,
        public ?string $cityUuid = null,
        public ?bool $deleted = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            code: isset($data['code']) ? (int) $data['code'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            dateTime: isset($data['date_time']) ? (string) $data['date_time'] : null,
            reasonCode: isset($data['reason_code']) ? (int) $data['reason_code'] : null,
            city: isset($data['city']) ? (string) $data['city'] : null,
            cityUuid: isset($data['city_uuid']) ? (string) $data['city_uuid'] : null,
            deleted: isset($data['deleted']) ? (bool) $data['deleted'] : null,
        );
    }
}
