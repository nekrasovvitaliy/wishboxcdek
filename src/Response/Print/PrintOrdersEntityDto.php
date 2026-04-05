<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Print;

final readonly class PrintOrdersEntityDto
{
    /**
     * @param list<PrintOrderDto> $orders
     * @param list<PrintStatusDto> $statuses
     */
    public function __construct(
        public ?string $uuid = null,
        public array $orders = [],
        public ?int $copyCount = null,
        public ?string $type = null,
        public ?string $url = null,
        public array $statuses = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        $orders = [];
        foreach (($data['orders'] ?? []) as $order) {
            if (is_array($order)) {
                $orders[] = PrintOrderDto::fromArray($order);
            }
        }

        $statuses = [];
        foreach (($data['statuses'] ?? []) as $status) {
            if (is_array($status)) {
                $statuses[] = PrintStatusDto::fromArray($status);
            }
        }

        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            orders: $orders,
            copyCount: isset($data['copy_count']) ? (int) $data['copy_count'] : null,
            type: isset($data['type']) ? (string) $data['type'] : null,
            url: isset($data['url']) ? (string) $data['url'] : null,
            statuses: $statuses,
        );
    }
}