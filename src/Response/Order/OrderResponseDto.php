<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Order;

final readonly class OrderResponseDto
{
    /**
     * @param list<int> $additionalOrderTypes
     * @param list<DeliveryCostThresholdDto> $deliveryRecipientCostAdv
     * @param list<AdditionalServiceResponseDto> $services
     * @param list<PackageResponseDto> $packages
     * @param list<OrderStatusDto> $statuses
     * @param list<OrderDelayReason> $delayReasons
     * @param list<mixed> $deliveryTypes
     * @param list<DeliveryProblemResponseDto> $deliveryProblem
     */
    public function __construct(
        public ?string $uuid = null,
        public ?int $type = null,
        public array $additionalOrderTypes = [],
        public ?bool $isReturn = null,
        public ?bool $isReverse = null,
        public ?string $cdekNumber = null,
        public ?string $number = null,
        public ?string $accompanyingNumber = null,
        public ?AccompanyingWaybillDto $accompanyingWaybill = null,
        public ?int $tariffCode = null,
        public ?string $comment = null,
        public ?string $shipmentPoint = null,
        public ?string $deliveryPoint = null,
        public ?string $dateInvoice = null,
        public ?string $keepFreeUntil = null,
        public ?string $shipperName = null,
        public ?string $shipperAddress = null,
        public ?DeliveryRecipientCostResponseDto $deliveryRecipientCost = null,
        public array $deliveryRecipientCostAdv = [],
        public ?SenderResponseContactDto $sender = null,
        public ?SellerItemDto $seller = null,
        public ?RecipientResponseContactDto $recipient = null,
        public ?ResponseFromLocationDto $fromLocation = null,
        public ?ResponseToLocationDto $toLocation = null,
        public array $services = [],
        public array $packages = [],
        public array $statuses = [],
        public ?bool $isClientReturn = null,
        public ?int $deliveryMode = null,
        public ?bool $hasReverseOrder = null,
        public array $delayReasons = [],
        public array $deliveryTypes = [],
        public ?string $plannedDeliveryDate = null,
        public ?ResponseDeliveryDetailDto $deliveryDetail = null,
        public array $deliveryProblem = [],
        public ?string $developerKey = null,
        public ?CallsResponseDto $calls = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $deliveryRecipientCostAdv = [];
        if (isset($data['delivery_recipient_cost_adv']) && is_array($data['delivery_recipient_cost_adv'])) {
            foreach ($data['delivery_recipient_cost_adv'] as $item) {
                if (is_array($item)) {
                    $deliveryRecipientCostAdv[] = DeliveryCostThresholdDto::fromArray($item);
                }
            }
        }

        $services = [];
        if (isset($data['services']) && is_array($data['services'])) {
            foreach ($data['services'] as $service) {
                if (is_array($service)) {
                    $services[] = AdditionalServiceResponseDto::fromArray($service);
                }
            }
        }

        $packages = [];
        if (isset($data['packages']) && is_array($data['packages'])) {
            foreach ($data['packages'] as $package) {
                if (is_array($package)) {
                    $packages[] = PackageResponseDto::fromArray($package);
                }
            }
        }

        $statuses = [];
        if (isset($data['statuses']) && is_array($data['statuses'])) {
            foreach ($data['statuses'] as $status) {
                if (is_array($status)) {
                    $statuses[] = OrderStatusDto::fromArray($status);
                }
            }
        }

        $delayReasons = [];
        if (isset($data['delay_reasons']) && is_array($data['delay_reasons'])) {
            foreach ($data['delay_reasons'] as $reason) {
                if (is_array($reason)) {
                    $delayReasons[] = OrderDelayReason::fromArray($reason);
                }
            }
        }

        $deliveryProblem = [];
        if (isset($data['delivery_problem']) && is_array($data['delivery_problem'])) {
            foreach ($data['delivery_problem'] as $problem) {
                if (is_array($problem)) {
                    $deliveryProblem[] = DeliveryProblemResponseDto::fromArray($problem);
                }
            }
        }

        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            type: isset($data['type']) ? (int) $data['type'] : null,
            additionalOrderTypes: isset($data['additional_order_types']) && is_array($data['additional_order_types']) ? array_values(array_map('intval', $data['additional_order_types'])) : [],
            isReturn: isset($data['is_return']) ? (bool) $data['is_return'] : null,
            isReverse: isset($data['is_reverse']) ? (bool) $data['is_reverse'] : null,
            cdekNumber: isset($data['cdek_number']) ? (string) $data['cdek_number'] : null,
            number: isset($data['number']) ? (string) $data['number'] : null,
            accompanyingNumber: isset($data['accompanying_number']) ? (string) $data['accompanying_number'] : null,
            accompanyingWaybill: isset($data['accompanying_waybill']) && is_array($data['accompanying_waybill']) ? AccompanyingWaybillDto::fromArray($data['accompanying_waybill']) : null,
            tariffCode: isset($data['tariff_code']) ? (int) $data['tariff_code'] : null,
            comment: isset($data['comment']) ? (string) $data['comment'] : null,
            shipmentPoint: isset($data['shipment_point']) ? (string) $data['shipment_point'] : null,
            deliveryPoint: isset($data['delivery_point']) ? (string) $data['delivery_point'] : null,
            dateInvoice: isset($data['date_invoice']) ? (string) $data['date_invoice'] : null,
            keepFreeUntil: isset($data['keep_free_until']) ? (string) $data['keep_free_until'] : null,
            shipperName: isset($data['shipper_name']) ? (string) $data['shipper_name'] : null,
            shipperAddress: isset($data['shipper_address']) ? (string) $data['shipper_address'] : null,
            deliveryRecipientCost: isset($data['delivery_recipient_cost']) && is_array($data['delivery_recipient_cost']) ? DeliveryRecipientCostResponseDto::fromArray($data['delivery_recipient_cost']) : null,
            deliveryRecipientCostAdv: $deliveryRecipientCostAdv,
            sender: isset($data['sender']) && is_array($data['sender']) ? SenderResponseContactDto::fromArray($data['sender']) : null,
            seller: isset($data['seller']) && is_array($data['seller']) ? SellerItemDto::fromArray($data['seller']) : null,
            recipient: isset($data['recipient']) && is_array($data['recipient']) ? RecipientResponseContactDto::fromArray($data['recipient']) : null,
            fromLocation: isset($data['from_location']) && is_array($data['from_location']) ? ResponseFromLocationDto::fromArray($data['from_location']) : null,
            toLocation: isset($data['to_location']) && is_array($data['to_location']) ? ResponseToLocationDto::fromArray($data['to_location']) : null,
            services: $services,
            packages: $packages,
            statuses: $statuses,
            isClientReturn: isset($data['is_client_return']) ? (bool) $data['is_client_return'] : null,
            deliveryMode: isset($data['delivery_mode']) ? (int) $data['delivery_mode'] : null,
            hasReverseOrder: isset($data['has_reverse_order']) ? (bool) $data['has_reverse_order'] : null,
            delayReasons: $delayReasons,
            deliveryTypes: isset($data['delivery_types']) && is_array($data['delivery_types']) ? array_values($data['delivery_types']) : [],
            plannedDeliveryDate: isset($data['planned_delivery_date']) ? (string) $data['planned_delivery_date'] : null,
            deliveryDetail: isset($data['delivery_detail']) && is_array($data['delivery_detail']) ? ResponseDeliveryDetailDto::fromArray($data['delivery_detail']) : null,
            deliveryProblem: $deliveryProblem,
            developerKey: isset($data['developer_key']) ? (string) $data['developer_key'] : null,
            calls: isset($data['calls']) && is_array($data['calls']) ? CallsResponseDto::fromArray($data['calls']) : null,
        );
    }
}
