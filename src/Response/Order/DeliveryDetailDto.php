<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class DeliveryDetailDto
{
    /**
     * @param list<PaymentInfoDto> $paymentInfo
     */
    public function __construct(
        public ?string $date = null,
        public ?string $recipientName = null,
        public int|float|null $paymentSum = null,
        public int|float|null $deliverySum = null,
        public int|float|null $totalSum = null,
        public array $paymentInfo = [],
        public ?int $deliveryVatRate = null,
        public int|float|null $deliveryVatSum = null,
        public int|float|null $deliveryDiscountPercent = null,
        public int|float|null $deliveryDiscountSum = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $paymentInfo = [];
        if (isset($data['payment_info']) && is_array($data['payment_info'])) {
            foreach ($data['payment_info'] as $item) {
                if (is_array($item)) {
                    $paymentInfo[] = PaymentInfoDto::fromArray($item);
                }
            }
        }

        return new self(
            date: isset($data['date']) ? (string) $data['date'] : null,
            recipientName: isset($data['recipient_name']) ? (string) $data['recipient_name'] : null,
            paymentSum: isset($data['payment_sum']) ? (is_int($data['payment_sum']) ? $data['payment_sum'] : (float) $data['payment_sum']) : null,
            deliverySum: isset($data['delivery_sum']) ? (is_int($data['delivery_sum']) ? $data['delivery_sum'] : (float) $data['delivery_sum']) : null,
            totalSum: isset($data['total_sum']) ? (is_int($data['total_sum']) ? $data['total_sum'] : (float) $data['total_sum']) : null,
            paymentInfo: $paymentInfo,
            deliveryVatRate: isset($data['delivery_vat_rate']) ? (int) $data['delivery_vat_rate'] : null,
            deliveryVatSum: isset($data['delivery_vat_sum']) ? (is_int($data['delivery_vat_sum']) ? $data['delivery_vat_sum'] : (float) $data['delivery_vat_sum']) : null,
            deliveryDiscountPercent: isset($data['delivery_discount_percent']) ? (is_int($data['delivery_discount_percent']) ? $data['delivery_discount_percent'] : (float) $data['delivery_discount_percent']) : null,
            deliveryDiscountSum: isset($data['delivery_discount_sum']) ? (is_int($data['delivery_discount_sum']) ? $data['delivery_discount_sum'] : (float) $data['delivery_discount_sum']) : null,
        );
    }
}
