<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: ReverseValidateRequestDto
 *
 * Запрос на проверку доступности реверса по данным прямого заказа
 */
final readonly class ReverseValidateRequestDto
{
    public mixed $fromLocation;

    public mixed $shipmentPoint;

    public mixed $toLocation;

    public mixed $deliveryPoint;

    public mixed $tariffCode;

    public mixed $sender;

    public mixed $recipient;

    public function __construct(
        mixed $fromLocation = null,
        mixed $shipmentPoint = null,
        mixed $toLocation = null,
        mixed $deliveryPoint = null,
        mixed $tariffCode = null,
        mixed $sender = null,
        mixed $recipient = null,
    ) {
        $this->fromLocation = $fromLocation;
        $this->shipmentPoint = $shipmentPoint;
        $this->toLocation = $toLocation;
        $this->deliveryPoint = $deliveryPoint;
        $this->tariffCode = $tariffCode;
        $this->sender = $sender;
        $this->recipient = $recipient;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            fromLocation: $data['from_location'] ?? null,
            shipmentPoint: $data['shipment_point'] ?? null,
            toLocation: $data['to_location'] ?? null,
            deliveryPoint: $data['delivery_point'] ?? null,
            tariffCode: $data['tariff_code'] ?? null,
            sender: $data['sender'] ?? null,
            recipient: $data['recipient'] ?? null,
        );
    }
}
