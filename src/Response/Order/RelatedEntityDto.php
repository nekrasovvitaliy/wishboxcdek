<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class RelatedEntityDto
{
    public function __construct(
        public ?string $uuid = null,
        public ?string $type = null,
        public ?string $url = null,
        public ?string $createTime = null,
        public ?string $cdekNumber = null,
        public ?string $date = null,
        public ?string $timeFrom = null,
        public ?string $timeTo = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            type: isset($data['type']) ? (string) $data['type'] : null,
            url: isset($data['url']) ? (string) $data['url'] : null,
            createTime: isset($data['create_time']) ? (string) $data['create_time'] : null,
            cdekNumber: isset($data['cdek_number']) ? (string) $data['cdek_number'] : null,
            date: isset($data['date']) ? (string) $data['date'] : null,
            timeFrom: isset($data['time_from']) ? (string) $data['time_from'] : null,
            timeTo: isset($data['time_to']) ? (string) $data['time_to'] : null,
        );
    }
}
