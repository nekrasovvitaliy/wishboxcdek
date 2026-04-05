<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Delivery;

use WishboxCdek\Request\RequestData;

final readonly class RegisterDeliveryRequest extends RequestData
{
    public function __construct(
        public ?string $cdekNumber = null,
        public ?string $orderUuid = null,
        public ?string $date = null,
        public ?string $timeFrom = null,
        public ?string $timeTo = null,
        public ?string $comment = null,
        public ?string $deliveryPoint = null,
        public ?LocationDto $toLocation = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'cdek_number' => $this->cdekNumber,
            'order_uuid' => $this->orderUuid,
            'date' => $this->date,
            'time_from' => $this->timeFrom,
            'time_to' => $this->timeTo,
            'comment' => $this->comment,
            'delivery_point' => $this->deliveryPoint,
            'to_location' => $this->toLocation,
        ]);
    }
}