<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class ItemResponseDto
{
    public function __construct(
        public ?string $name = null,
        public ?string $wareKey = null,
        public ?string $marking = null,
        public ?ResponseMoneyDto $payment = null,
        public ?int $weight = null,
        public ?int $weightGross = null,
        public int|float|null $amount = null,
        public int|float|null $deliveryAmount = null,
        public ?string $nameI18n = null,
        public ?string $brand = null,
        public ?string $countryCode = null,
        public ?string $material = null,
        public ?string $wifiGsm = null,
        public ?string $url = null,
        public ?SellerItemDto $seller = null,
        public ?ReturnItemDetail $returnItemDetail = null,
        public int|float|null $excise = null,
        public int|float|null $cost = null,
        public ?string $feacnCode = null,
        public ?string $jewelUin = null,
        public ?bool $used = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: isset($data['name']) ? (string) $data['name'] : null,
            wareKey: isset($data['ware_key']) ? (string) $data['ware_key'] : null,
            marking: isset($data['marking']) ? (string) $data['marking'] : null,
            payment: isset($data['payment']) && is_array($data['payment']) ? ResponseMoneyDto::fromArray($data['payment']) : null,
            weight: isset($data['weight']) ? (int) $data['weight'] : null,
            weightGross: isset($data['weight_gross']) ? (int) $data['weight_gross'] : null,
            amount: isset($data['amount']) ? (is_int($data['amount']) ? $data['amount'] : (float) $data['amount']) : null,
            deliveryAmount: isset($data['delivery_amount']) ? (is_int($data['delivery_amount']) ? $data['delivery_amount'] : (float) $data['delivery_amount']) : null,
            nameI18n: isset($data['name_i18n']) ? (string) $data['name_i18n'] : null,
            brand: isset($data['brand']) ? (string) $data['brand'] : null,
            countryCode: isset($data['country_code']) ? (string) $data['country_code'] : null,
            material: isset($data['material']) ? (string) $data['material'] : null,
            wifiGsm: isset($data['wifi_gsm']) ? (string) $data['wifi_gsm'] : null,
            url: isset($data['url']) ? (string) $data['url'] : null,
            seller: isset($data['seller']) && is_array($data['seller']) ? SellerItemDto::fromArray($data['seller']) : null,
            returnItemDetail: isset($data['return_item_detail']) && is_array($data['return_item_detail']) ? ReturnItemDetail::fromArray($data['return_item_detail']) : null,
            excise: isset($data['excise']) ? (is_int($data['excise']) ? $data['excise'] : (float) $data['excise']) : null,
            cost: isset($data['cost']) ? (is_int($data['cost']) ? $data['cost'] : (float) $data['cost']) : null,
            feacnCode: isset($data['feacn_code']) ? (string) $data['feacn_code'] : null,
            jewelUin: isset($data['jewel_uin']) ? (string) $data['jewel_uin'] : null,
            used: isset($data['used']) ? (bool) $data['used'] : null,
        );
    }
}
