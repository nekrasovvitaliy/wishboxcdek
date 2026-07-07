<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: ScheduleInfoDto
 *
 * Договоренность о доставке
 */
final readonly class ScheduleInfoDto
{
    public mixed $cdekNumber;

    public ?string $orderUuid;

    public ?string $date;

    public mixed $timeFrom;

    public mixed $timeTo;

    public mixed $comment;

    public mixed $deliveryPoint;

    public mixed $toLocation;

    public ?string $uuid;

    /**
     * @var array<int|string, mixed> of ScheduleStatusDto
     */
    public array $statuses;

    public mixed $source;

    public function __construct(
        mixed $cdekNumber = null,
        ?string $orderUuid = null,
        ?string $date = null,
        mixed $timeFrom = null,
        mixed $timeTo = null,
        mixed $comment = null,
        mixed $deliveryPoint = null,
        mixed $toLocation = null,
        ?string $uuid = null,
        array $statuses = [],
        mixed $source = null,
    ) {
        $this->cdekNumber = $cdekNumber;
        $this->orderUuid = $orderUuid;
        $this->date = $date;
        $this->timeFrom = $timeFrom;
        $this->timeTo = $timeTo;
        $this->comment = $comment;
        $this->deliveryPoint = $deliveryPoint;
        $this->toLocation = $toLocation;
        $this->uuid = $uuid;
        $this->statuses = $statuses;
        $this->source = $source;
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
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            statuses: isset($data['statuses']) && is_array($data['statuses']) ? $data['statuses'] : [],
            source: $data['source'] ?? null,
        );
    }
}
