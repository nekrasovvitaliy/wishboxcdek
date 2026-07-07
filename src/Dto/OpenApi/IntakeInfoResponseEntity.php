<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: IntakeInfoResponseEntity
 *
 * Информация о заявке
 */
final readonly class IntakeInfoResponseEntity
{
    public ?string $uuid;

    public mixed $cdekNumber;

    public mixed $orderUuid;

    public mixed $intakeDate;

    public mixed $intakeNumber;

    public mixed $intakeTimeFrom;

    public mixed $intakeTimeTo;

    public mixed $lunchTimeFrom;

    public mixed $lunchTimeTo;

    public mixed $name;

    public mixed $weight;

    public mixed $length;

    public mixed $width;

    public mixed $height;

    public mixed $comment;

    public mixed $courierPowerOfAttorney;

    public mixed $courierIdentityCard;

    public mixed $sender;

    public mixed $fromLocation;

    public mixed $toLocation;

    public mixed $needCall;

    /**
     * @var array<int|string, mixed> of IntakeStatusDto
     */
    public array $statuses;

    /**
     * @var array<int|string, mixed> of IntakePackageDto
     */
    public array $packages;

    public function __construct(
        ?string $uuid = null,
        mixed $cdekNumber = null,
        mixed $orderUuid = null,
        mixed $intakeDate = null,
        mixed $intakeNumber = null,
        mixed $intakeTimeFrom = null,
        mixed $intakeTimeTo = null,
        mixed $lunchTimeFrom = null,
        mixed $lunchTimeTo = null,
        mixed $name = null,
        mixed $weight = null,
        mixed $length = null,
        mixed $width = null,
        mixed $height = null,
        mixed $comment = null,
        mixed $courierPowerOfAttorney = null,
        mixed $courierIdentityCard = null,
        mixed $sender = null,
        mixed $fromLocation = null,
        mixed $toLocation = null,
        mixed $needCall = null,
        array $statuses = [],
        array $packages = [],
    ) {
        $this->uuid = $uuid;
        $this->cdekNumber = $cdekNumber;
        $this->orderUuid = $orderUuid;
        $this->intakeDate = $intakeDate;
        $this->intakeNumber = $intakeNumber;
        $this->intakeTimeFrom = $intakeTimeFrom;
        $this->intakeTimeTo = $intakeTimeTo;
        $this->lunchTimeFrom = $lunchTimeFrom;
        $this->lunchTimeTo = $lunchTimeTo;
        $this->name = $name;
        $this->weight = $weight;
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
        $this->comment = $comment;
        $this->courierPowerOfAttorney = $courierPowerOfAttorney;
        $this->courierIdentityCard = $courierIdentityCard;
        $this->sender = $sender;
        $this->fromLocation = $fromLocation;
        $this->toLocation = $toLocation;
        $this->needCall = $needCall;
        $this->statuses = $statuses;
        $this->packages = $packages;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            cdekNumber: $data['cdek_number'] ?? null,
            orderUuid: $data['order_uuid'] ?? null,
            intakeDate: $data['intake_date'] ?? null,
            intakeNumber: $data['intake_number'] ?? null,
            intakeTimeFrom: $data['intake_time_from'] ?? null,
            intakeTimeTo: $data['intake_time_to'] ?? null,
            lunchTimeFrom: $data['lunch_time_from'] ?? null,
            lunchTimeTo: $data['lunch_time_to'] ?? null,
            name: $data['name'] ?? null,
            weight: $data['weight'] ?? null,
            length: $data['length'] ?? null,
            width: $data['width'] ?? null,
            height: $data['height'] ?? null,
            comment: $data['comment'] ?? null,
            courierPowerOfAttorney: $data['courier_power_of_attorney'] ?? null,
            courierIdentityCard: $data['courier_identity_card'] ?? null,
            sender: $data['sender'] ?? null,
            fromLocation: $data['from_location'] ?? null,
            toLocation: $data['to_location'] ?? null,
            needCall: $data['need_call'] ?? null,
            statuses: isset($data['statuses']) && is_array($data['statuses']) ? $data['statuses'] : [],
            packages: isset($data['packages']) && is_array($data['packages']) ? $data['packages'] : [],
        );
    }
}
