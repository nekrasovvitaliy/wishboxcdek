<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Calculator;

final readonly class AvailableTariffCodeDto
{
    /**
     * @param list<?int> $orderTypes
     * @param list<?int> $payerContragentType
     * @param list<?int> $senderContragentType
     * @param list<?int> $recipientContragentType
     * @param list<AvailableTariffDeliveryModeDto> $deliveryModes
     */
    public function __construct(
        public ?string $tariffName = null,
        public ?float $weightMin = null,
        public ?float $weightMax = null,
        public ?float $weightCalcMax = null,
        public ?int $lengthMin = null,
        public ?int $lengthMax = null,
        public ?int $widthMin = null,
        public ?int $widthMax = null,
        public ?int $heightMin = null,
        public ?int $heightMax = null,
        public array $orderTypes = [],
        public array $payerContragentType = [],
        public array $senderContragentType = [],
        public array $recipientContragentType = [],
        public array $deliveryModes = [],
        public ?AvailableTariffAdditionalOrderTypesParamDto $additionalOrderTypesParam = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            tariffName: isset($data['tariff_name']) ? (string) $data['tariff_name'] : null,
            weightMin: isset($data['weight_min']) ? (float) $data['weight_min'] : null,
            weightMax: isset($data['weight_max']) ? (float) $data['weight_max'] : null,
            weightCalcMax: isset($data['weight_calc_max']) ? (float) $data['weight_calc_max'] : null,
            lengthMin: isset($data['length_min']) ? (int) $data['length_min'] : null,
            lengthMax: isset($data['length_max']) ? (int) $data['length_max'] : null,
            widthMin: isset($data['width_min']) ? (int) $data['width_min'] : null,
            widthMax: isset($data['width_max']) ? (int) $data['width_max'] : null,
            heightMin: isset($data['height_min']) ? (int) $data['height_min'] : null,
            heightMax: isset($data['height_max']) ? (int) $data['height_max'] : null,
            orderTypes: self::normalizeNullableIntList($data['order_types'] ?? []),
            payerContragentType: self::normalizeNullableIntList($data['payer_contragent_type'] ?? []),
            senderContragentType: self::normalizeNullableIntList($data['sender_contragent_type'] ?? []),
            recipientContragentType: self::normalizeNullableIntList($data['recipient_contragent_type'] ?? []),
            deliveryModes: array_map(
                static fn (array $item): AvailableTariffDeliveryModeDto => AvailableTariffDeliveryModeDto::fromArray($item),
                array_values(array_filter(
                    $data['delivery_modes'] ?? [],
                    static fn (mixed $item): bool => is_array($item),
                )),
            ),
            additionalOrderTypesParam: isset($data['additional_order_types_param']) && is_array($data['additional_order_types_param'])
                ? AvailableTariffAdditionalOrderTypesParamDto::fromArray($data['additional_order_types_param'])
                : null,
        );
    }

    /**
     * @return list<?int>
     */
    private static function normalizeNullableIntList(array $values): array
    {
        return array_values(array_map(
            static fn (mixed $item): ?int => $item === null ? null : (int) $item,
            $values,
        ));
    }
}
