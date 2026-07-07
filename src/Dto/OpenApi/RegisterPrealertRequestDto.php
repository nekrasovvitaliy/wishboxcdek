<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: RegisterPrealertRequestDto
 *
 * Запрос на регистрацию преалерта
 */
final readonly class RegisterPrealertRequestDto
{
    public ?string $plannedDate;

    public mixed $shipmentPoint;

    /**
     * @var array<int|string, mixed> of RegisterPrealertRequestDtoOrderDto
     */
    public array $orders;

    public function __construct(
        ?string $plannedDate = null,
        mixed $shipmentPoint = null,
        array $orders = [],
    ) {
        $this->plannedDate = $plannedDate;
        $this->shipmentPoint = $shipmentPoint;
        $this->orders = $orders;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            plannedDate: isset($data['planned_date']) ? (string) $data['planned_date'] : null,
            shipmentPoint: $data['shipment_point'] ?? null,
            orders: isset($data['orders']) && is_array($data['orders']) ? $data['orders'] : [],
        );
    }
}
