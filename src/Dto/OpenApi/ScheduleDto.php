<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: ScheduleDto
 *
 * Договоренность о доставке
 */
final readonly class ScheduleDto
{
    public mixed $cdekNumber;

    public ?string $orderUuid;

    public ?string $date;

    public mixed $timeFrom;

    public mixed $timeTo;

    public mixed $comment;

    public mixed $deliveryPoint;

    public mixed $toLocation;

    public function __construct(
        mixed $cdekNumber = null,
        ?string $orderUuid = null,
        ?string $date = null,
        mixed $timeFrom = null,
        mixed $timeTo = null,
        mixed $comment = null,
        mixed $deliveryPoint = null,
        mixed $toLocation = null,
    ) {
        $this->cdekNumber = $cdekNumber;
        $this->orderUuid = $orderUuid;
        $this->date = $date;
        $this->timeFrom = $timeFrom;
        $this->timeTo = $timeTo;
        $this->comment = $comment;
        $this->deliveryPoint = $deliveryPoint;
        $this->toLocation = $toLocation;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            cdekNumber: $data['cdek_number'] ?? null,
            orderUuid: isset($data['order_uuid']) ? (string) $data['order_uuid'] : null,
            date: isset($data['date']) ? (string) $data['date'] : null,
            timeFrom: $data['time_from'] ?? null,
            timeTo: $data['time_to'] ?? null,
            comment: $data['comment'] ?? null,
            deliveryPoint: $data['delivery_point'] ?? null,
            toLocation: $data['to_location'] ?? null,
        );
    }
}
