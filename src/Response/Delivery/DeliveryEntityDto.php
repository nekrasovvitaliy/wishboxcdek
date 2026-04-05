<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Delivery;

final readonly class DeliveryEntityDto
{
    /**
     * @param list<DeliveryStatusDto> $statuses
     */
    public function __construct(
        public ?string $cdekNumber = null,
        public ?string $orderUuid = null,
        public ?string $date = null,
        public ?string $timeFrom = null,
        public ?string $timeTo = null,
        public ?string $comment = null,
        public ?string $deliveryPoint = null,
        public ?DeliveryLocationDto $toLocation = null,
        public ?string $uuid = null,
        public array $statuses = [],
        public ?string $source = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $statuses = [];
        foreach (($data['statuses'] ?? []) as $status) {
            if (is_array($status)) {
                $statuses[] = DeliveryStatusDto::fromArray($status);
            }
        }

        return new self(
            cdekNumber: isset($data['cdek_number']) ? (string) $data['cdek_number'] : null,
            orderUuid: isset($data['order_uuid']) ? (string) $data['order_uuid'] : null,
            date: isset($data['date']) ? (string) $data['date'] : null,
            timeFrom: isset($data['time_from']) ? (string) $data['time_from'] : null,
            timeTo: isset($data['time_to']) ? (string) $data['time_to'] : null,
            comment: isset($data['comment']) ? (string) $data['comment'] : null,
            deliveryPoint: isset($data['delivery_point']) ? (string) $data['delivery_point'] : null,
            toLocation: isset($data['to_location']) && is_array($data['to_location']) ? DeliveryLocationDto::fromArray($data['to_location']) : null,
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            statuses: $statuses,
            source: isset($data['source']) ? (string) $data['source'] : null,
        );
    }
}