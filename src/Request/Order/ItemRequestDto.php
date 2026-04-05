<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use WishboxCdek\Request\RequestData;

final readonly class ItemRequestDto extends RequestData
{
    public function __construct(
        public string $name,
        public string $wareKey,
        public MoneyDto $payment,
        public int|float $cost,
        public int $weight,
        public int|float $amount,
        public ?string $comment = null,
        public ?string $marking = null,
        public ?int $weightGross = null,
        public ?string $nameI18n = null,
        public ?string $brand = null,
        public ?string $countryCode = null,
        public ?string $material = null,
        public ?string $wifiGsm = null,
        public ?string $url = null,
        public ?SellerDto $seller = null,
        public ?string $feacnCode = null,
        public ?string $jewelUin = null,
        public ?bool $used = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'name' => $this->name,
            'ware_key' => $this->wareKey,
            'marking' => $this->marking,
            'payment' => $this->payment,
            'weight' => $this->weight,
            'weight_gross' => $this->weightGross,
            'amount' => $this->amount,
            'name_i18n' => $this->nameI18n,
            'brand' => $this->brand,
            'country_code' => $this->countryCode,
            'material' => $this->material,
            'wifi_gsm' => $this->wifiGsm,
            'url' => $this->url,
            'seller' => $this->seller,
            'cost' => $this->cost,
            'feacn_code' => $this->feacnCode,
            'jewel_uin' => $this->jewelUin,
            'used' => $this->used,
        ]);
    }
}
