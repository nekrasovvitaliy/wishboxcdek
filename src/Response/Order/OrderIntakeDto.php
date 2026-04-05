<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class OrderIntakeDto
{
    /**
     * @param list<OrderIntakeStatusDto> $statuses
     * @param list<OrderIntakePackageDto> $packages
     */
    public function __construct(
        public ?string $uuid = null,
        public ?string $cdekNumber = null,
        public ?string $orderUuid = null,
        public ?string $intakeDate = null,
        public ?string $intakeNumber = null,
        public ?string $intakeTimeFrom = null,
        public ?string $intakeTimeTo = null,
        public ?string $lunchTimeFrom = null,
        public ?string $lunchTimeTo = null,
        public ?string $name = null,
        public ?int $weight = null,
        public ?int $length = null,
        public ?int $width = null,
        public ?int $height = null,
        public ?string $comment = null,
        public ?bool $courierPowerOfAttorney = null,
        public ?bool $courierIdentityCard = null,
        public ?ContactDto $sender = null,
        public ?LocationDto $fromLocation = null,
        public ?LocationDto $toLocation = null,
        public ?bool $needCall = null,
        public array $statuses = [],
        public array $packages = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        $statuses = [];
        foreach (($data['statuses'] ?? []) as $status) {
            if (is_array($status)) {
                $statuses[] = OrderIntakeStatusDto::fromArray($status);
            }
        }

        $packages = [];
        foreach (($data['packages'] ?? []) as $package) {
            if (is_array($package)) {
                $packages[] = OrderIntakePackageDto::fromArray($package);
            }
        }

        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            cdekNumber: isset($data['cdek_number']) ? (string) $data['cdek_number'] : null,
            orderUuid: isset($data['order_uuid']) ? (string) $data['order_uuid'] : null,
            intakeDate: isset($data['intake_date']) ? (string) $data['intake_date'] : null,
            intakeNumber: isset($data['intake_number']) ? (string) $data['intake_number'] : null,
            intakeTimeFrom: isset($data['intake_time_from']) ? (string) $data['intake_time_from'] : null,
            intakeTimeTo: isset($data['intake_time_to']) ? (string) $data['intake_time_to'] : null,
            lunchTimeFrom: isset($data['lunch_time_from']) ? (string) $data['lunch_time_from'] : null,
            lunchTimeTo: isset($data['lunch_time_to']) ? (string) $data['lunch_time_to'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            weight: isset($data['weight']) ? (int) $data['weight'] : null,
            length: isset($data['length']) ? (int) $data['length'] : null,
            width: isset($data['width']) ? (int) $data['width'] : null,
            height: isset($data['height']) ? (int) $data['height'] : null,
            comment: isset($data['comment']) ? (string) $data['comment'] : null,
            courierPowerOfAttorney: isset($data['courier_power_of_attorney']) ? (bool) $data['courier_power_of_attorney'] : null,
            courierIdentityCard: isset($data['courier_identity_card']) ? (bool) $data['courier_identity_card'] : null,
            sender: isset($data['sender']) && is_array($data['sender']) ? ContactDto::fromArray($data['sender']) : null,
            fromLocation: isset($data['from_location']) && is_array($data['from_location']) ? LocationDto::fromArray($data['from_location']) : null,
            toLocation: isset($data['to_location']) && is_array($data['to_location']) ? LocationDto::fromArray($data['to_location']) : null,
            needCall: isset($data['need_call']) ? (bool) $data['need_call'] : null,
            statuses: $statuses,
            packages: $packages,
        );
    }
}

