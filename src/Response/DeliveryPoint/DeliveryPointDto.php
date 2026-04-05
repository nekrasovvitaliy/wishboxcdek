<?php

declare(strict_types=1);

namespace WishboxCdek\Response\DeliveryPoint;

use WishboxCdek\Response\Error\CdekMessage;

final readonly class DeliveryPointDto
{
    /**
     * @param list<DeliveryPointPhoneDto> $phones
     * @param list<DeliveryPointOfficeImageDto> $officeImageList
     * @param list<DeliveryPointWorkTimeDto> $workTimeList
     * @param list<DeliveryPointWorkTimeExceptionDto> $workTimeExceptionList
     * @param list<DeliveryPointDimensionDto> $dimensions
     * @param list<CdekMessage> $errors
     * @param list<CdekMessage> $warnings
     */
    public function __construct(
        public ?string $code = null,
        public ?string $uuid = null,
        public ?string $name = null,
        public ?string $addressComment = null,
        public ?string $nearestStation = null,
        public ?string $nearestMetroStation = null,
        public ?string $workTime = null,
        public array $phones = [],
        public ?string $email = null,
        public ?string $note = null,
        public ?string $type = null,
        public ?string $ownerCode = null,
        public ?bool $takeOnly = null,
        public ?bool $isHandout = null,
        public ?bool $isReception = null,
        public ?bool $isDressingRoom = null,
        public ?bool $isMarketplace = null,
        public ?bool $isLtl = null,
        public ?bool $haveCashless = null,
        public ?bool $haveCash = null,
        public ?bool $haveFastPaymentSystem = null,
        public ?bool $allowedCod = null,
        public ?string $site = null,
        public array $officeImageList = [],
        public array $workTimeList = [],
        public array $workTimeExceptionList = [],
        public ?float $weightMin = null,
        public ?float $weightMax = null,
        public array $dimensions = [],
        public array $errors = [],
        public array $warnings = [],
        public ?DeliveryPointLocationDto $location = null,
        public ?float $distance = null,
        public ?bool $ltlAcceptancePartners = null,
        public ?bool $ltlIssuancePartners = null,
        public ?bool $fulfillment = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: isset($data['code']) ? (string) $data['code'] : null,
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            name: isset($data['name']) ? (string) $data['name'] : null,
            addressComment: isset($data['address_comment']) ? (string) $data['address_comment'] : null,
            nearestStation: isset($data['nearest_station']) ? (string) $data['nearest_station'] : null,
            nearestMetroStation: isset($data['nearest_metro_station']) ? (string) $data['nearest_metro_station'] : null,
            workTime: isset($data['work_time']) ? (string) $data['work_time'] : null,
            phones: array_map(
                static fn (array $phone): DeliveryPointPhoneDto => DeliveryPointPhoneDto::fromArray($phone),
                is_array($data['phones'] ?? null) ? $data['phones'] : [],
            ),
            email: isset($data['email']) ? (string) $data['email'] : null,
            note: isset($data['note']) ? (string) $data['note'] : null,
            type: isset($data['type']) ? (string) $data['type'] : null,
            ownerCode: isset($data['owner_code']) ? (string) $data['owner_code'] : null,
            takeOnly: isset($data['take_only']) ? (bool) $data['take_only'] : null,
            isHandout: isset($data['is_handout']) ? (bool) $data['is_handout'] : null,
            isReception: isset($data['is_reception']) ? (bool) $data['is_reception'] : null,
            isDressingRoom: isset($data['is_dressing_room']) ? (bool) $data['is_dressing_room'] : null,
            isMarketplace: isset($data['is_marketplace']) ? (bool) $data['is_marketplace'] : null,
            isLtl: isset($data['is_ltl']) ? (bool) $data['is_ltl'] : null,
            haveCashless: isset($data['have_cashless']) ? (bool) $data['have_cashless'] : null,
            haveCash: isset($data['have_cash']) ? (bool) $data['have_cash'] : null,
            haveFastPaymentSystem: isset($data['have_fast_payment_system']) ? (bool) $data['have_fast_payment_system'] : null,
            allowedCod: isset($data['allowed_cod']) ? (bool) $data['allowed_cod'] : null,
            site: isset($data['site']) ? (string) $data['site'] : null,
            officeImageList: array_map(
                static fn (array $image): DeliveryPointOfficeImageDto => DeliveryPointOfficeImageDto::fromArray($image),
                is_array($data['office_image_list'] ?? null) ? $data['office_image_list'] : [],
            ),
            workTimeList: array_map(
                static fn (array $workTime): DeliveryPointWorkTimeDto => DeliveryPointWorkTimeDto::fromArray($workTime),
                is_array($data['work_time_list'] ?? null) ? $data['work_time_list'] : [],
            ),
            workTimeExceptionList: array_map(
                static fn (array $exception): DeliveryPointWorkTimeExceptionDto => DeliveryPointWorkTimeExceptionDto::fromArray($exception),
                is_array($data['work_time_exception_list'] ?? null) ? $data['work_time_exception_list'] : [],
            ),
            weightMin: isset($data['weight_min']) ? (float) $data['weight_min'] : null,
            weightMax: isset($data['weight_max']) ? (float) $data['weight_max'] : null,
            dimensions: array_map(
                static fn (array $dimension): DeliveryPointDimensionDto => DeliveryPointDimensionDto::fromArray($dimension),
                is_array($data['dimensions'] ?? null) ? $data['dimensions'] : [],
            ),
            errors: array_map(
                static fn (array $error): CdekMessage => CdekMessage::fromArray($error),
                is_array($data['errors'] ?? null) ? $data['errors'] : [],
            ),
            warnings: array_map(
                static fn (array $warning): CdekMessage => CdekMessage::fromArray($warning),
                is_array($data['warnings'] ?? null) ? $data['warnings'] : [],
            ),
            location: is_array($data['location'] ?? null) ? DeliveryPointLocationDto::fromArray($data['location']) : null,
            distance: isset($data['distance']) ? (float) $data['distance'] : null,
            ltlAcceptancePartners: isset($data['ltl_acceptance_partners']) ? (bool) $data['ltl_acceptance_partners'] : null,
            ltlIssuancePartners: isset($data['ltl_issuance_partners']) ? (bool) $data['ltl_issuance_partners'] : null,
            fulfillment: isset($data['fulfillment']) ? (bool) $data['fulfillment'] : null,
        );
    }
}
