<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use WishboxCdek\Enum\AdditionalOrderType;
use WishboxCdek\Enum\OrderType;
use WishboxCdek\Request\RequestData;

final readonly class UpdateOrderRequest extends RequestData
{
    /**
     * @param list<PackageRequestDto> $packages
     * @param list<AdditionalOrderType> $additionalOrderTypes
     * @param list<DeliveryRecipientCostAdvDto> $deliveryRecipientCostAdv
     * @param list<AdditionalServiceRequestDto> $services
     */
    private function __construct(
        public readonly OrderType $type,
        public readonly int $tariffCode,
        public readonly ContactDto $sender,
        public readonly ContactDto $recipient,
        public readonly array $packages,
        public readonly ?string $uuid = null,
        public readonly ?string $cdekNumber = null,
        public readonly array $additionalOrderTypes = [],
        public readonly ?string $number = null,
        public readonly ?string $accompanyingNumber = null,
        public readonly ?string $comment = null,
        public readonly ?string $shipmentPoint = null,
        public readonly ?string $deliveryPoint = null,
        public readonly ?string $dateInvoice = null,
        public readonly ?string $shipperName = null,
        public readonly ?string $shipperAddress = null,
        public readonly ?MoneyDto $deliveryRecipientCost = null,
        public readonly array $deliveryRecipientCostAdv = [],
        public readonly ?SellerDto $seller = null,
        public readonly ?LocationDto $fromLocation = null,
        public readonly ?LocationDto $toLocation = null,
        public readonly array $services = [],
        public readonly ?bool $isClientReturn = null,
        public readonly ?bool $hasReverseOrder = null,
        public readonly ?string $developerKey = null,
        public readonly ?string $print = null,
        public readonly ?string $widgetToken = null,
    ) {
    }

    /**
     * @param list<PackageRequestDto> $packages
     */
    public static function make(
        OrderType $type,
        int $tariffCode,
        ContactDto $sender,
        ContactDto $recipient,
        array $packages,
    ): self {
        return new self(
            type: $type,
            tariffCode: $tariffCode,
            sender: $sender,
            recipient: $recipient,
            packages: $packages,
        );
    }

    public function withUuid(string $uuid): self
    {
        return $this->rebuild(uuid: $uuid);
    }

    public function withCdekNumber(string $cdekNumber): self
    {
        return $this->rebuild(cdekNumber: $cdekNumber);
    }

    /**
     * @param list<AdditionalOrderType> $additionalOrderTypes
     */
    public function withAdditionalOrderTypes(array $additionalOrderTypes): self
    {
        return $this->rebuild(additionalOrderTypes: $additionalOrderTypes);
    }

    public function withNumber(string $number): self
    {
        return $this->rebuild(number: $number);
    }

    public function withAccompanyingNumber(string $accompanyingNumber): self
    {
        return $this->rebuild(accompanyingNumber: $accompanyingNumber);
    }

    public function withComment(string $comment): self
    {
        return $this->rebuild(comment: $comment);
    }

    public function withShipmentPoint(string $shipmentPoint): self
    {
        return $this->rebuild(shipmentPoint: $shipmentPoint);
    }

    public function withDeliveryPoint(string $deliveryPoint): self
    {
        return $this->rebuild(deliveryPoint: $deliveryPoint);
    }

    public function withDateInvoice(string $dateInvoice): self
    {
        return $this->rebuild(dateInvoice: $dateInvoice);
    }

    public function withShipperName(string $shipperName): self
    {
        return $this->rebuild(shipperName: $shipperName);
    }

    public function withShipperAddress(string $shipperAddress): self
    {
        return $this->rebuild(shipperAddress: $shipperAddress);
    }

    public function withDeliveryRecipientCost(MoneyDto $deliveryRecipientCost): self
    {
        return $this->rebuild(deliveryRecipientCost: $deliveryRecipientCost);
    }

    /**
     * @param list<DeliveryRecipientCostAdvDto> $deliveryRecipientCostAdv
     */
    public function withDeliveryRecipientCostAdv(array $deliveryRecipientCostAdv): self
    {
        return $this->rebuild(deliveryRecipientCostAdv: $deliveryRecipientCostAdv);
    }

    public function withSeller(SellerDto $seller): self
    {
        return $this->rebuild(seller: $seller);
    }

    public function withFromLocation(LocationDto $fromLocation): self
    {
        return $this->rebuild(fromLocation: $fromLocation);
    }

    public function withToLocation(LocationDto $toLocation): self
    {
        return $this->rebuild(toLocation: $toLocation);
    }

    /**
     * @param list<AdditionalServiceRequestDto> $services
     */
    public function withServices(array $services): self
    {
        return $this->rebuild(services: $services);
    }

    public function withIsClientReturn(bool $isClientReturn): self
    {
        return $this->rebuild(isClientReturn: $isClientReturn);
    }

    public function withHasReverseOrder(bool $hasReverseOrder): self
    {
        return $this->rebuild(hasReverseOrder: $hasReverseOrder);
    }

    public function withDeveloperKey(string $developerKey): self
    {
        return $this->rebuild(developerKey: $developerKey);
    }

    public function withPrint(string $print): self
    {
        return $this->rebuild(print: $print);
    }

    public function withWidgetToken(string $widgetToken): self
    {
        return $this->rebuild(widgetToken: $widgetToken);
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'uuid' => $this->uuid,
            'type' => $this->type->value,
            'cdek_number' => $this->cdekNumber,
            'additional_order_types' => $this->additionalOrderTypes === []
                ? null
                : array_map(static fn (AdditionalOrderType $type): int => $type->value, $this->additionalOrderTypes),
            'number' => $this->number,
            'accompanying_number' => $this->accompanyingNumber,
            'tariff_code' => $this->tariffCode,
            'comment' => $this->comment,
            'shipment_point' => $this->shipmentPoint,
            'delivery_point' => $this->deliveryPoint,
            'date_invoice' => $this->dateInvoice,
            'shipper_name' => $this->shipperName,
            'shipper_address' => $this->shipperAddress,
            'delivery_recipient_cost' => $this->deliveryRecipientCost,
            'delivery_recipient_cost_adv' => $this->deliveryRecipientCostAdv === [] ? null : $this->deliveryRecipientCostAdv,
            'sender' => $this->sender,
            'seller' => $this->seller,
            'recipient' => $this->recipient,
            'from_location' => $this->fromLocation,
            'to_location' => $this->toLocation,
            'services' => $this->services === [] ? null : $this->services,
            'packages' => $this->packages,
            'is_client_return' => $this->isClientReturn,
            'has_reverse_order' => $this->hasReverseOrder,
            'developer_key' => $this->developerKey,
            'print' => $this->print,
            'widget_token' => $this->widgetToken,
        ]);
    }

    private function rebuild(
        ?string $uuid = null,
        ?string $cdekNumber = null,
        ?array $additionalOrderTypes = null,
        ?string $number = null,
        ?string $accompanyingNumber = null,
        ?string $comment = null,
        ?string $shipmentPoint = null,
        ?string $deliveryPoint = null,
        ?string $dateInvoice = null,
        ?string $shipperName = null,
        ?string $shipperAddress = null,
        ?MoneyDto $deliveryRecipientCost = null,
        ?array $deliveryRecipientCostAdv = null,
        ?SellerDto $seller = null,
        ?LocationDto $fromLocation = null,
        ?LocationDto $toLocation = null,
        ?array $services = null,
        ?bool $isClientReturn = null,
        ?bool $hasReverseOrder = null,
        ?string $developerKey = null,
        ?string $print = null,
        ?string $widgetToken = null,
    ): self {
        return new self(
            type: $this->type,
            tariffCode: $this->tariffCode,
            sender: $this->sender,
            recipient: $this->recipient,
            packages: $this->packages,
            uuid: $uuid ?? $this->uuid,
            cdekNumber: $cdekNumber ?? $this->cdekNumber,
            additionalOrderTypes: $additionalOrderTypes ?? $this->additionalOrderTypes,
            number: $number ?? $this->number,
            accompanyingNumber: $accompanyingNumber ?? $this->accompanyingNumber,
            comment: $comment ?? $this->comment,
            shipmentPoint: $shipmentPoint ?? $this->shipmentPoint,
            deliveryPoint: $deliveryPoint ?? $this->deliveryPoint,
            dateInvoice: $dateInvoice ?? $this->dateInvoice,
            shipperName: $shipperName ?? $this->shipperName,
            shipperAddress: $shipperAddress ?? $this->shipperAddress,
            deliveryRecipientCost: $deliveryRecipientCost ?? $this->deliveryRecipientCost,
            deliveryRecipientCostAdv: $deliveryRecipientCostAdv ?? $this->deliveryRecipientCostAdv,
            seller: $seller ?? $this->seller,
            fromLocation: $fromLocation ?? $this->fromLocation,
            toLocation: $toLocation ?? $this->toLocation,
            services: $services ?? $this->services,
            isClientReturn: $isClientReturn ?? $this->isClientReturn,
            hasReverseOrder: $hasReverseOrder ?? $this->hasReverseOrder,
            developerKey: $developerKey ?? $this->developerKey,
            print: $print ?? $this->print,
            widgetToken: $widgetToken ?? $this->widgetToken,
        );
    }
}
