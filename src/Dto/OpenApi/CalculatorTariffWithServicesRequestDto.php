<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: CalculatorTariffWithServicesRequestDto
 *
 * Запрос на расчет по доступным тарифам с учетом дополнительных услуг
 */
final readonly class CalculatorTariffWithServicesRequestDto
{
    public mixed $date;

    public mixed $type;

    public mixed $currency;

    public mixed $lang;

    public mixed $fromLocation;

    public mixed $toLocation;

    /**
     * @var array<int|string, mixed> of CalcAdditionalServiceDto
     */
    public array $services;

    /**
     * @var array<int|string, mixed> of CalcPackageRequestDto
     */
    public array $packages;

    /**
     * @var array<int|string, mixed>
     */
    public array $additionalOrderTypes;

    public mixed $shipmentPoint;

    public mixed $deliveryPoint;

    public function __construct(
        mixed $date = null,
        mixed $type = null,
        mixed $currency = null,
        mixed $lang = null,
        mixed $fromLocation = null,
        mixed $toLocation = null,
        array $services = [],
        array $packages = [],
        array $additionalOrderTypes = [],
        mixed $shipmentPoint = null,
        mixed $deliveryPoint = null,
    ) {
        $this->date = $date;
        $this->type = $type;
        $this->currency = $currency;
        $this->lang = $lang;
        $this->fromLocation = $fromLocation;
        $this->toLocation = $toLocation;
        $this->services = $services;
        $this->packages = $packages;
        $this->additionalOrderTypes = $additionalOrderTypes;
        $this->shipmentPoint = $shipmentPoint;
        $this->deliveryPoint = $deliveryPoint;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            date: $data['date'] ?? null,
            type: $data['type'] ?? null,
            currency: $data['currency'] ?? null,
            lang: $data['lang'] ?? null,
            fromLocation: $data['from_location'] ?? null,
            toLocation: $data['to_location'] ?? null,
            services: isset($data['services']) && is_array($data['services']) ? $data['services'] : [],
            packages: isset($data['packages']) && is_array($data['packages']) ? $data['packages'] : [],
            additionalOrderTypes: isset($data['additional_order_types']) && is_array($data['additional_order_types']) ? $data['additional_order_types'] : [],
            shipmentPoint: $data['shipment_point'] ?? null,
            deliveryPoint: $data['delivery_point'] ?? null,
        );
    }
}
