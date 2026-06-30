<?php

declare(strict_types=1);

namespace WishboxCdek\Request\DeliveryPoint;

use WishboxCdek\Enum\DeliveryPointType;
use WishboxCdek\Enum\Language;
use WishboxCdek\Request\RequestData;

final readonly class GetDeliveryPointsRequest extends RequestData
{
    public function __construct(
        public ?string $countryCode = null,
        public ?string $fiasRegionGuid = null,
        public ?int $regionCode = null,
        public ?string $postalCode = null,
        public ?int $cityCode = null,
        public ?string $kladrCode = null,
        public ?string $fiasGuid = null,
        public ?string $city = null,
        public ?float $paymentLimit = null,
        public ?DeliveryPointType $type = null,
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
        public ?float $weightMin = null,
        public ?float $weightMax = null,
        public ?int $page = null,
        public ?int $size = null,
        public ?Language $lang = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'country_code' => $this->countryCode,
            'fias_region_guid' => $this->fiasRegionGuid,
            'region_code' => $this->regionCode,
            'postal_code' => $this->postalCode,
            'city_code' => $this->cityCode,
            'kladr_code' => $this->kladrCode,
            'fias_guid' => $this->fiasGuid,
            'city' => $this->city,
            'payment_limit' => $this->paymentLimit,
            'type' => $this->type?->value,
            'owner_code' => $this->ownerCode,
            'take_only' => $this->takeOnly,
            'is_handout' => $this->isHandout,
            'is_reception' => $this->isReception,
            'is_dressing_room' => $this->isDressingRoom,
            'is_marketplace' => $this->isMarketplace,
            'is_ltl' => $this->isLtl,
            'have_cashless' => $this->haveCashless,
            'have_cash' => $this->haveCash,
            'have_fast_payment_system' => $this->haveFastPaymentSystem,
            'allowed_cod' => $this->allowedCod,
            'weight_min' => $this->weightMin,
            'weight_max' => $this->weightMax,
            'page' => $this->page,
            'size' => $this->size,
            'lang' => $this->lang?->value,
        ]);
    }
}
