<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class AccompanyingWaybillDto
{
    /**
     * @param list<string> $airWaybillNumbers
     * @param list<string> $vehicleNumbers
     */
    public function __construct(
        public ?string $clientName = null,
        public ?string $flightNumber = null,
        public array $airWaybillNumbers = [],
        public array $vehicleNumbers = [],
        public ?string $vehicleDriver = null,
        public ?string $plannedDepartureDateTime = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            clientName: isset($data['client_name']) ? (string) $data['client_name'] : null,
            flightNumber: isset($data['flight_number']) ? (string) $data['flight_number'] : null,
            airWaybillNumbers: isset($data['air_waybill_numbers']) && is_array($data['air_waybill_numbers']) ? array_values(array_map('strval', $data['air_waybill_numbers'])) : [],
            vehicleNumbers: isset($data['vehicle_numbers']) && is_array($data['vehicle_numbers']) ? array_values(array_map('strval', $data['vehicle_numbers'])) : [],
            vehicleDriver: isset($data['vehicle_driver']) ? (string) $data['vehicle_driver'] : null,
            plannedDepartureDateTime: isset($data['planned_departure_date_time']) ? (string) $data['planned_departure_date_time'] : null,
        );
    }
}
